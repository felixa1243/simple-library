<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->bothify('BK-###'),
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'stock' => $this->faker->numberBetween(0, 5),
        ];
    }
}
