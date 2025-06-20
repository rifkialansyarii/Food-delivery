<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->comment('User ID')->nullable();
            $table->foreignId('menu_id')->constrained('menus')->comment('Menu ID')->nullable();
            $table->foreignId('driver_id')->constrained('drivers')->comment('Driver')->default(0)->nullable();
            $table->string('amount')->comment('Order amount');
            $table->string('total')->comment('Total');
            $table->string('status')->default('Selesai')->comment('Order status');
            $table->string('location')->comment('Delivery address');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
