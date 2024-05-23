<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if(!User::where('email', 'davigadelhadev@gmail.com')->first())
        {
            User::create([
                'name' => 'Davi',
                'email' => 'davigadelhadev@gmai.com',
                'password' => Hash::make('gadelhadav2121', ['rounds' => 12])
            ]);
        }
    }
}
