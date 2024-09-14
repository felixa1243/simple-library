<?php

namespace Database\Factories;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->bothify('M###'),
            'name' => $this->faker->name(),
        ];
    }
}
