<?php

namespace Database\Seeders;
use App\Models\AccessToken;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccessToken::create([
            'token' => md5('string'),
            'host' => 'http://localhost',
        ]);
    }
}
