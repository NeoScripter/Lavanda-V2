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

        (new ImageFactory)->create(
            attrs: ['imageable_type' => $imageable_type, 'imageable_id' => $item->id, 'variant' => 'image'],
            src_dir: APP_DIR . '/db/Fixtures/Image/front_image/',
        );

        return $item;
    }

    public function seed(array $attrs, string $img_src, string $file)
    {
        if (! isset($attrs['abstract'])) {
            throw new \RuntimeException("Abstract is not provided");
        }
        if (! isset($attrs['description'])) {
            throw new \RuntimeException("Description is not provided");
        }
        if (! isset($attrs['title'])) {
            throw new \RuntimeException("Title is not provided");
        }
        if (! isset($attrs['faqs'])) {
            throw new \RuntimeException("Faqs are not provided");
        }
        if (! is_file($file)) {
            throw new \RuntimeException("File $file doesn't exist");
        }

        $new_dir = \UPLOAD_DIR . '/' . uniqid() . '/';

        if (!is_dir($new_dir)) {
            mkdir($new_dir, 0755, true);
        }

        $to = remove_extra_slashes($new_dir . '/' . extract_file_name($file));

        if (!copy(to: $to, from: $file)) {
            throw new \RuntimeException("Failed to copy $file to $to");
        }

        $contents = $attrs['faqs'];

        $chunks = array_map(
            fn($chunk) => trim($chunk),
            array_filter(
                mb_split('##', $contents),
                fn($chunk) => !empty($chunk)
            )
        );

        $faqs = [];

        foreach ($chunks as $chunk) {
            [$question, $answer] = mb_split("\n\n", $chunk);
            $faqs[] = compact('question', 'answer');
        }

        $item = new PracticeItem();
        $item->file = to_public_url($to);
        $item->description = $attrs['description'];
        $item->title = $attrs['title'];
        $item->abstract = $attrs['abstract'];
        $item->faqs = $faqs;
        $item->save();

        $img_attrs = [
            'imageable_type' => ImageableType::PRACTICE_ITEM->value,
            'imageable_id' => $item->id,
        ];

        (new ImageFactory)->create(
            attrs: array_merge($img_attrs, ['variant' => 'image']),
            src_dir: $img_src
        );

        return $item;
    }
}
