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
        Schema::create('check_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id");
            $table->string("amount", 16);
            $table->string("tracking_code", 32);
            $table->tinyInteger("status")->default(0);
            $table->bigInteger("due_date")->unsigned();
            $table->bigInteger("created_at")->unsigned();
            $table->bigInteger("updated_at")->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_details');
    }
};
