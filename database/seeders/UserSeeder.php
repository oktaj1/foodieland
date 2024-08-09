<?php

namespace Database\Seeders;

use App\Models\User;
use App\Traits\hasulid;
use PharIo\Manifest\Email;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(1)->create([
            'email' => 'oktajid@gmail.com',
            'password' => bcrypt('password'),
            ]);
    }
}
