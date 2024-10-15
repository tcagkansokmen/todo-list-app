<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        Task::create(['name' => 'Task 1', 'duration' => 10, 'difficulty' => 1]);
        Task::create(['name' => 'Task 2', 'duration' => 20, 'difficulty' => 2]);
        Task::create(['name' => 'Task 3', 'duration' => 30, 'difficulty' => 3]);
    }
}
