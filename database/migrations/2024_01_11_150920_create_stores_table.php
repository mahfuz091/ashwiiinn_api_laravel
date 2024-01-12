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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('address_line')->nullable();
            $table->string('street')->nullable();
            $table->foreignId('city_id')->nullable()->index();
            $table->foreignId('state_id')->nullable()->index();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('country_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
