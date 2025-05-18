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
    Schema::create('diploma_registrations', function (Blueprint $table) {
        $table->id();
        $table->string('register_id')->unique();
        $table->string('diploma_name'); // auto-filled hidden field
        $table->string('full_name');
        $table->string('name_with_initials');
        $table->enum('gender', ['Male', 'Female']);
        $table->string('national_id_number');
        $table->date('date_of_birth');
        $table->string('email');
        $table->text('permanent_address');
        $table->string('postal_code');
        $table->string('home_contact_number');
        $table->string('whatsapp_number');
        $table->string('payment_slip'); // file path
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diploma_registrations');
    }
};
