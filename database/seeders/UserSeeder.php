<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
           'name' => 'Rajan',
           'email' => 'rajan@gmail.com'
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com'
        ]);

        User::factory()->create([
            'name' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'role' => 'instructor'
        ]);

        User::factory()->create([
            'name' => 'Teacher 2',
            'email' => 'teacher2@gmail.com',
            'role' => 'instructor'
        ]);
        User::factory()->count(10)->create();

        User::factory()->count(10)->create([
            'role' => 'instructor',
        ]);
    }
}
