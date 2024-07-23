<?php

declare(strict_types=1);

namespace App\Tests\Tool;

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    private ?Generator $faker = null;

    public function getFaker(): Generator
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }
}
