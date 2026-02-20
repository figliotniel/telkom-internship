<?php

namespace Database\Factories;

use App\Models\DailyLogbook;
use App\Models\Internship;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyLogbookFactory extends Factory
{
    protected $model = DailyLogbook::class;

    public function definition(): array
    {
        return [
            'internship_id' => Internship::factory(),
            'date' => fake()->date(),
            'activity' => fake()->sentence(10),
            'status' => fake()->randomElement(['approved', 'pending', 'rejected']),
            'mentor_note' => fake()->optional()->sentence(),
        ];
    }
}
