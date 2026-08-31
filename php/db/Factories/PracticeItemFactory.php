<?php

declare(strict_types=1);

namespace Factories;

use Enums\ImageableType;
use Http\Models\PracticeItem;

class PracticeItemFactory extends Factory
{
    public function create(?array $attrs = [])
    {
        $item = new PracticeItem();

        $item->title = $attrs['title'] ?? $this->faker->words(4, true);
        $item->description = $attrs['description'] ??  $this->faker->sentence();
        $item->abstract = $attrs['abstract'] ??  $this->faker->sentence();
        $item->file = $attrs['file'] ?? $this->faker->url();

        $faqs = $attrs['faqs'] ?? [];

        if (! isset($attrs['faqs'])) {

            for ($i = 0; $i < 6; $i++) {
                $question = $this->faker->words(4, true);
                $answer = $this->faker->sentence();

                $faq = compact('question', 'answer');
                $faqs[] = $faq;
            }
        }

        $item->faqs = $faqs;

        $item->save();

        $imageable_type = ImageableType::PRACTICE_ITEM->value;

        (new ImageFactory)->create(dir: 'test', imageable_type: $imageable_type, imageable_id: $item->id, variant: 'image');

        return $item;
    }
}
