<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\FAQ;

class FAQFactory extends Factory
{
    public function create(?array $attrs = [])
    {
        $faq = new FAQ();

        $faq->question = $attrs['name'] ?? $this->faker->sentence();
        $faq->answer = $attrs['advice'] ??  $this->faker->sentences(3, true);

        $faq->save();

        return $faq;
    }
}
