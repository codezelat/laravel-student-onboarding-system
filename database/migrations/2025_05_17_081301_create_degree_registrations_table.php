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
        Schema::create('degree_registrations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Registration Details (from the form)
            $table->string('register_id')->unique(); // Assuming register_id should be unique

            // Personal Information (from the form)
            $table->string('full_name');
            $table->string('name_with_initials');
            $table->string('gender');
            $table->string('date_of_birth'); // Storing as string, consider 'date' type if needed
            $table->string('national_id_number');
            $table->string('passport_number')->nullable(); // Optional
            $table->string('nationality');
            $table->string('country_birth');
            $table->string('country_residence');
            $table->text('disability')->nullable(); // Optional, using text for potentially longer descriptions

            // Contact Information (from the form)
            $table->string('email'); // Consider unique() if emails should be unique per registration
            $table->string('whatsapp_number');
            $table->string('home_contact_number')->nullable(); // Optional
            $table->text('permanent_address');
            $table->string('postal_code');
            $table->string('district');

            // Academic Information (from the form)
            $table->string('student_id')->nullable(); // Although required in form, nullable might be safer initially? Let's make it required based on form.
             $table->string('student_id'); // Required based on form
            $table->string('medium');
            $table->string('guardian_name');
            $table->string('guardian_contact_number');
            $table->string('first_choice'); // Storing the selected program value
            $table->string('degree_program_name')->after('first_choice'); 

            // File Upload Fields (Storing Paths) - Recommended to be nullable as files might not always exist
            $table->string('ol_result_sheet')->nullable();
            $table->string('al_result_sheet')->nullable();
            $table->string('id_card_copy')->nullable();
            $table->string('it_certificate')->nullable();
            $table->string('application_form')->nullable(); // PSBU Application
            $table->string('passport_photo')->nullable(); // 2x2 inch photo
            $table->string('payment_slip')->nullable(); // From your original fillable

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('degree_registrations');
    }
};
