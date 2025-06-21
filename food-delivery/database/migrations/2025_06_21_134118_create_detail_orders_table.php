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
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("merchant_id");
            $table->unsignedBigInteger("menu_id");
            $table->unsignedBigInteger("driver_id")->nullable();
            $table->integer("stok");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("merchant_id")->references("id")->on("merchants");
            $table->foreign("menu_id")->references("id")->on("menus");
            $table->foreign("driver_id")->references("id")->on("users");
            $table->foreign("order_id")->references("id")->on("orders");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_orders');
    }
};
