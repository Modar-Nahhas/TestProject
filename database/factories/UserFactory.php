<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->numberBetween(1,1000000),
            'karma_score' => $this->faker->numberBetween(1,1000000),
            'image_id' => Image::all()->random()->id,
        ];
    }
}
