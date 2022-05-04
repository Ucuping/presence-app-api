<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'shift_id' => 1,
                'name' => 'Dafid Prasetyo',
                'username' => 'dafidpr',
                'email' => 'dafidpr@gmail.com',
                'password' => Hash::make('1234'),
            ],
            [
                'shift_id' => 2,
                'name' => 'Dimas Anggara',
                'username' => 'dimas',
                'email' => 'dimas@gmail.com',
                'password' => Hash::make('1234'),
            ],
        ]);
    }
}
