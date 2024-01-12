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
        // Schema::create('countries', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('iso_alpha_2', 2);
        //     $table->string('iso_alpha_3', 3);
        //     $table->integer('iso_numeric');
        //     $table->string('currency_code');
        //     $table->string('currency_name');
        //     $table->string('currency_symbol');
        //     $table->string('flag');
        //     // Add any additional columns you may need

        //     $table->timestamps();
           
        // });
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('address_line')->nullable();
            $table->string('street')->nullable();
            $table->foreignId('city_id')->nullable()->index();
            $table->foreignId('state_id')->nullable()->index();
            $table->string('postal_code')->nullable();
            $table->foreignId('country_id')->nullable()->index();
            $table->string('phone')->nullable();
            $table->timestamps();
           
        });
        Schema::table('users', function (Blueprint $table) {
             
            $table->foreignId('billing_address_id')->nullable()->index()->after('phone');
            $table->foreignId('shipping_address_id')->nullable()->index()->after('billing_address_id');
           


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
