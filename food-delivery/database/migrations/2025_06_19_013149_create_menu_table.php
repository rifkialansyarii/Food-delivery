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
        Schema::create('menus', function (Blueprint $table) {
            $table->id()->comment('Menu ID'); 
            // $table->foreignId('merchant_id')->constrained('merchants')->comment('Merchant ID')->nullable();
            $table->unsignedBigInteger("merchant_id");
            $table->string("name")->comment('Menu name'); 
            $table->string("price")->comment('Menu price'); 
            $table->string("picture")->nullable()->comment('Menu picture'); 
            $table->string("status")->default('Available')->comment('Menu status');

            $table->timestamps();

            $table->foreign("merchant_id")->references("id")->on("merchants");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
