<?php

namespace Database\Seeders;

use App\Models\ScheduledClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduledClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScheduledClass::factory()->count(10)->create();
    }
}
