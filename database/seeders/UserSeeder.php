<?php

namespace Database\Seeders;

use App\Models\User;
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
        $users = [
            [
                'name' => 'Joe Dave',
                'email' => 'joedave@mail.com',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'Yessica Tamara',
                'email' => 'chika@mail.com',
                'password' => Hash::make('12345'),
            ],
        ];

        foreach ($users as $key => $value) {
            User::create($value);
        }
    }
}
