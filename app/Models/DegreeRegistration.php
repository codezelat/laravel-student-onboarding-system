<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DegreeRegistration extends Model
{
    protected $fillable = [
        'register_id',
        'full_name',
        'name_with_initials',
        'gender',
        'date_of_birth',
        'national_id_number',
        'passport_number',
        'nationality',
        'country_birth',
        'country_residence',
        'disability',
        'email',
        'whatsapp_number',
        'home_contact_number',
        'permanent_address',
        'postal_code',
        'district',
        'student_id',
        'medium',
        'guardian_name',
        'guardian_contact_number',
        'first_choice',
        'degree_program_name',
        'ol_result_sheet',
        'al_result_sheet',
        'id_card_copy',
        'it_certificate',
        'application_form',
        'passport_photo',
        'payment_slip',
    ];
}
