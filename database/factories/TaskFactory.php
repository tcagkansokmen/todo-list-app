<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'duration' => $this->faker->numberBetween(1, 5),
            'difficulty' => $this->faker->numberBetween(1, 3),
        ];
    }
}
