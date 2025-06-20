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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id()->comment('Merchant ID');  
            $table->string("name")->comment('Merchant name'); 
            $table->string("address")->comment('Merchant address');
            $table->string("phone")->comment('Merchant phone'); 
            $table->string("picture")->nullable()->comment('Merchant picture'); 
            $table->string("status")->default('Open')->comment('Merchant status');
            $table->boolean("is_verified")->default('1')->comment('Merchant verification status'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant');
    }
};
