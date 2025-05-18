<?php

namespace App\Exports;

use App\Models\DegreeRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class DegreeRegistrationsExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = DegreeRegistration::query();

        if ($this->request->filled('search')) {
            $search = $this->request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('register_id', 'like', "%{$search}%")
                  ->orWhere('national_id_number', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('degree')) {
            $query->where('degree_program_name', $this->request->input('degree'));
        }

        return $query->orderBy('created_at', 'desc')->get([
            'register_id',
            'degree_program_name',
            'full_name',
            'name_with_initials',
            'gender',
            'date_of_birth',
            'national_id_number',
            'email',
            'permanent_address',
            'postal_code',
            'district',
            'home_contact_number',
            'whatsapp_number',
            'student_id',
            'medium',
            'guardian_name',
            'guardian_contact_number',
            'disability',
            'passport_number',
            'first_choice',
            'country_residence',
            'country_birth',
            'nationality',
            'ol_result_sheet',
            'al_result_sheet',
            'id_card_copy',
            'it_certificate',
            'application_form',
            'passport_photo',
            'payment_slip',
            'created_at'
        ]);
    }

    public function headings(): array
    {
        return [
            'Register ID',
            'Degree Program',
            'Full Name',
            'Name with Initials',
            'Gender',
            'Date of Birth',
            'NIC',
            'Email',
            'Permanent Address',
            'Postal Code',
            'District',
            'Home Contact Number',
            'WhatsApp Number',
            'Student ID',
            'Medium',
            'Guardian Name',
            'Guardian Contact Number',
            'Disability',
            'Passport Number',
            'First Choice',
            'Country of Residence',
            'Country of Birth',
            'Nationality',
            'OL Result Sheet',
            'AL Result Sheet',
            'ID Card Copy',
            'IT Certificate',
            'Application Form',
            'Passport Photo',
            'Payment Slip',
            'Submitted At'
        ];
    }
}
