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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("payable");
            $table->integer("count")->unsigned();
            $table->integer("color_id")->unsigned();
            $table->string("unit_price", 16);
            $table->tinyInteger("status")->default(1);
            $table->bigInteger("created_at")->unsigned();
            $table->bigInteger("updated_at")->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
