<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'fname' => 'Boyet',
            'mname' => 'Abordo',
            'lname' => 'Dedal',
            'gender' => 'Male',
            'address' => 'Brgy.Baldoza,Hindang,Leyte',
            'contact' => '09123456789',
            'birthdate' => '2003-08-12',
            'age' => 21,
            'email' => 'boyet@gmail.com',
            'password' => bcrypt('boyet123'), // password
            'role' => 0,
        ]);
    }
}
