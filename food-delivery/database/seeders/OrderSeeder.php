<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'user_id' => 1,
            'menu_id' => 1,
            'driver_id' => 1,
            'amount' => 1,
            'total' => 12000,
            'location' => 'Jl. Alalak',
        ]);
    }
}
