<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\FAQ;

class FAQFactory extends Factory
{
    public function create(array $attrs)
    {
        $faq = new FAQ();
        $faq->copyfrom($attrs);
        $faq->save();

        return $faq;
    }
}
