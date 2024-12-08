<?php

namespace Database\Factories;

use App\Models\Clothes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class ClothesFactory extends Factory
{
    protected $model = Clothes::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(10, 100),
            'stock' => $this->faker->numberBetween(1, 50),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'limited_edition' => $this->faker->boolean,
            'color' => $this->faker->randomElements(['Red', 'Blue', 'Green', 'Yellow'], 2),
            'image' => UploadedFile::fake()->image('clothes.jpg')->store('images/clothes', 'public'),
        ];
    }
}
