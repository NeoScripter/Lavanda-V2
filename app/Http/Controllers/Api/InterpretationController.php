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
        $resource = $hive->GET['resource'];
        $ids = $hive->GET['ids'];

        if (! in_array($resource, MatcheableType::values())) {
            send_json(['message' =>  "Invalid resource type"], 400);
        }

        $ids = explode(',', $ids);
        $wildcards = to_wildcards($ids);

        $model = match ($resource) {
            MatcheableType::RUNE->value => RuneAsset::class,
            MatcheableType::STONE->value => StoneAsset::class,
            default => FlipCard::class,
        };

        $items = new $model();

        if ($model === FlipCard::class) {
            $sql = ["locale=? AND id IN ($wildcards) AND variant=?", $locale, ...$ids, $resource];
        } else {
            $sql = ["locale=? AND id IN ($wildcards)", $locale, ...$ids];
        }

        $items = $items->find($sql);

        if (! $items) {
            send_json(['message' =>  "Items not found"], 404);
        }

        $payload = [];

        foreach ($items as $item) {
            $payload[] = [
                'id' => $item->id,
                'name' => $item->name,
                'img' => $item->front_src,
                'alt' => $item->front_alt,
                'advice' => $item->advice,
                'themes' => get_unique_themes_by_type(ThemeableType::from($resource), $item->id),
            ];
        }

        send_json($payload);
    }
}
