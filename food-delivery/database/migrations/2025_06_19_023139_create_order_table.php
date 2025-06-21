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
            // $table->foreignId('user_id')->constrained('users')->comment('User ID')->nullable();
            // $table->foreignId('menu_id')->constrained('menus')->comment('Menu ID')->nullable();
            // $table->foreignId('driver_id')->constrained('drivers')->comment('Driver')->default(0)->nullable();
            $table->unsignedBigInteger("driver_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("merchant_id");
            $table->unsignedBigInteger("menu_id");
            $table->string('total')->comment('Total');
            $table->enum('status', ["selesai", "diantar", "pending"])->default('selesai')->comment('Order status');
            $table->string('location')->comment('Delivery address');

            $table->timestamps();

            $table->foreign("driver_id")->references("id")->on("users");
            $table->foreign("merchant_id")->references("id")->on("merchants");
            $table->foreign("menu_id")->references("id")->on("menus");
            $table->foreign("user_id")->references("id")->on("users");
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
