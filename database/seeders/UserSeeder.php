<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'username' => 'admin1',
            'password' => Hash::make('admin1@taatufnvc')
        ]);

        \App\Models\User::factory()->create([
            'username' => 'admin2',
            'password' => Hash::make('admin2@taatufnvc')
        ]);

        \App\Models\User::factory()->create([
            'username' => 'admin3',
            'password' => Hash::make('admin3@taatufnvc')
        ]);

        \App\Models\User::factory()->create([
            'username' => 'admin4',
            'password' => Hash::make('admin4@taatufnvc')
        ]);
        
        \App\Models\User::factory()->create([
            'username' => 'admin5',
            'password' => Hash::make('admin5@taatufnvc')
        ]);
    }
}
