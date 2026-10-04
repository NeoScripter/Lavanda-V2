<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Enums\MatcheableType;
use Enums\ThemeableType;
use Http\Controller;
use Http\Models\FlipCard;
use Http\Models\RuneAsset;
use Http\Models\StoneAsset;
use Support\Session;

class InterpretationController extends Controller
{
    public function __invoke(\Base $hive)
    {
        $locale = Session::get_locale();
        $category = $hive->GET['category'];
        $ids = $hive->GET['ids'];

        if (! in_array($category, MatcheableType::values())) {
            send_json(['message' =>  "Invalid category type"], 400);
        }

        $ids = explode(',', $ids);
        $wildcards = to_wildcards($ids);

        $model = match ($category) {
            MatcheableType::RUNE->value => RuneAsset::class,
            MatcheableType::STONE->value => StoneAsset::class,
            default => FlipCard::class,
        };

        $items = new $model();

        if ($model === FlipCard::class) {
            $sql = ["locale=? AND id IN ($wildcards) AND variant=?", $locale, ...$ids, $category];
        } else {
            $sql = ["locale=? AND id IN ($wildcards)", $locale, ...$ids];
        }

        $items = $items->find($sql);

        if (! $items) {
            send_json(['message' =>  "Items not found"], 404);
        }

        $db = $hive->get('DB');

        $all_themes = $db->exec(
                "SELECT * FROM themes WHERE themeable_type = ? AND themeable_id IN ($wildcards)",
                [$category, ...$ids]
            );

        $match_sets = $db->exec(
                "SELECT * FROM match_sets WHERE matcheable_type = ? AND locale = ? AND matcheable_id = ?",
                [$category, $locale, implode('|', $ids)]
            );

        $payload = ['items' => [], 'match_sets' => []];

        foreach ($items as $item) {
            $themes = [];

            foreach ($all_themes as $theme) {
                if ($theme['themeable_id'] === $item->id) {
                    $themes[] = $theme;
                }
            }

            $payload['items'][] = [
                'id' => $item->id,
                'name' => $item->name,
                'img' => $item->front_src,
                'alt' => $item->front_alt,
                'advice' => $item->advice,
                'themes' => $themes
            ];
        }

        $payload['match_sets'] = $match_sets;

        send_json($payload);
    }
}
