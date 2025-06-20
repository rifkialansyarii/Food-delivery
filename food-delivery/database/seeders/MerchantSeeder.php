<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Merchant::create([
            'name' => 'Warung Makan Sederhana',
            'address' => 'Jl. Raya No. 123, Jakarta',
            'phone' => '081234567890',
            'picture' => 'images/warung-nasgor.jpg',
        ]);
    }
}
