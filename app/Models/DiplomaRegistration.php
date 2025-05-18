<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiplomaRegistration extends Model
{
    protected $fillable = [
        'register_id',
        'diploma_name',
        'full_name',
        'name_with_initials',
        'gender',
        'national_id_number',
        'date_of_birth',
        'email',
        'permanent_address',
        'postal_code',
        'home_contact_number',
        'whatsapp_number',
        'payment_slip',
    ];
    
}
