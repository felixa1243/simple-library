<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    protected $model = Borrowing::class;

    public function definition()
    {
        return [
            'member_id' => Member::factory(), 
            'book_id' => Book::factory(),     
            'borrowed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'due_at' => $this->faker->dateTimeBetween('now', '+7 days'),
            'returned_at' => null,
        ];
    }

    // Optional state to simulate a returned book
    public function returned()
    {
        return $this->state(function (array $attributes) {
            return [
                'returned_at' => $this->faker->dateTimeBetween($attributes['borrowed_at'], 'now'),
            ];
        });
    }
}
