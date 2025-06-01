<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'), // Use a secure password
        ]);

        return $user;
    }
}
