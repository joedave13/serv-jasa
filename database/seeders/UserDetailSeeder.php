<?php

namespace Database\Seeders;

use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_details = [
            [
                'user_id' => 1,
                'role' => 'Website Developer',
                'contact_number' => '081458219890'
            ],
            [
                'user_id' => 2,
                'role' => 'UI Designer',
                'contact_number' => '082763345123'
            ]
        ];

        foreach ($user_details as $key => $value) {
            UserDetail::create($value);
        }
    }
}
