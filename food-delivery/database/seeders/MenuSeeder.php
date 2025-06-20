<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'merchant_id' => 1,
            'name' => 'Nasi Goreng',
            'price' => 15000,
            'picture' => 'images/nasgor.jpg',
        ]);
    }
}
