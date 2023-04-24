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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name", 64);
            $table->string("description", 256);
            $table->string("price", 16);
            $table->integer("category_id");
            $table->tinyInteger("wholesaleـdiscount")->nullable();
            $table->bigInteger("created_at")->unsigned();
            $table->bigInteger("updated_at")->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
