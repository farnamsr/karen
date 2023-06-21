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
        Schema::create('verification_messages', function (Blueprint $table) {
            $table->id();
            $table->integer("code");
            $table->tinyInteger("type");
            $table->string("phone_number");
            $table->string("ip", 64);
            $table->tinyInteger("status")->default(0);
            $table->bigInteger("created_at")->unsigned();
            $table->bigInteger("updated_at")->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_messages');
    }
};
