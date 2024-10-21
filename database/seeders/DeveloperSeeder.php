<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    public function run()
    {
        Developer::updateOrCreate(['name' => 'DEV1'], ['capacity' => 1]);
        Developer::updateOrCreate(['name' => 'DEV2'], ['capacity' => 2]);
        Developer::updateOrCreate(['name' => 'DEV3'], ['capacity' => 3]);
        Developer::updateOrCreate(['name' => 'DEV4'], ['capacity' => 4]);
        Developer::updateOrCreate(['name' => 'DEV5'], ['capacity' => 5]);
    }
}
