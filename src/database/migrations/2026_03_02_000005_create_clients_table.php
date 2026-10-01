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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('business_name')->nullable();
            $table->string('address');
            $table->string('residential_address')->nullable();
            $table->string('tin');
            $table->string('tel_phone_number');
            $table->string('email_address')->nullable();
            $table->string('id_presented')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('mothers_maiden_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('capitalization')->nullable();
            $table->text('notes')->nullable();
            $table->json('business_registrations')->nullable();
            $table->json('additional_requirements')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
