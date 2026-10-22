<?php

declare(strict_types=1);

namespace Http\Controllers\Api;

use Enums\MatcheableType;
use Http\Controller;
use Http\Models\FlipCard;
use Http\Models\MatchSetImage;
use Http\Models\RuneAsset;
use Http\Models\StoneAsset;
use Support\AccessStatus;
use Support\Auth;
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

        $free = [MatcheableType::BONUS->value];

        if (! in_array($category, $free)) {
            $user = Auth::user();

            if (empty($user) || ! AccessStatus::can_play_game($user)) {
                send_json(['message' =>  "You don't have the access to this game"], 403);
            }

            AccessStatus::subtract_game($user);
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

        $match_sets = new MatchSetImage();
        $match_sets = $match_sets->find(
            ['locale=? AND matcheable_type=? AND matcheable_id = ?', $locale, $category, implode('|', $ids)],
            ['order' => 'created_at DESC']
        );

        $match_sets = array_map(fn($set) => $set->to_resource(), $match_sets);

        $payload = ['items' => [], 'match_sets' => []];

        $markdown = \Markdown::instance();

        foreach ($items as $item) {
            $themes = [];

            foreach ($all_themes as $theme) {
                if ($theme['themeable_id'] === $item->id) {
                    // $theme['html'] = $markdown->convert($theme['html']);
                    $themes[] = $theme;
                }
            }

            $payload['items'][] = [
                'id' => $item->id,
                'name' => $item->name,
                'img' => $item->front_src ?? $item->image_src,
                'alt' => $item->front_alt ?? $item->image_alt,
                'advice' => $item->advice ?? '',
                'html' => $markdown->convert($item->html ?? ''),
                'themes' => $themes
            ];
        }

        $payload['match_sets'] = $match_sets;

        send_json($payload);
    }
}
