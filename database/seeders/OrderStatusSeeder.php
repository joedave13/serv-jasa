<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order_statuses = [
            [
                'name' => 'Approve'
            ],
            [
                'name' => 'Progress'
            ],
            [
                'name' => 'Rejected'
            ],
            [
                'name' => 'Waiting'
            ],
        ];

        foreach ($order_statuses as $key => $value) {
            OrderStatus::create($value);
        }
    }
}
