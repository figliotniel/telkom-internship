<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Internship;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        return [
            'internship_id' => Internship::factory(),
            'date' => fake()->date(),
            'status' => fake()->randomElement(['present', 'permit', 'sick']),
            'check_in' => '08:00:00',
            'check_out' => '17:00:00',
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
        ];
    }
}
