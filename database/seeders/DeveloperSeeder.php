<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    public function run()
    {
        Developer::create(['name' => 'DEV1', 'capacity' => 1]);
        Developer::create(['name' => 'DEV2', 'capacity' => 2]);
        Developer::create(['name' => 'DEV3', 'capacity' => 3]);
        Developer::create(['name' => 'DEV4', 'capacity' => 4]);
        Developer::create(['name' => 'DEV5', 'capacity' => 5]);
    }
}
