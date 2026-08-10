<?php

declare(strict_types=1);

namespace Factories;

abstract class Factory
{
    protected \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create('en_US');
    }
}
