<?php

namespace App\Exports;

use App\Models\DegreeRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;

class DegreeRegistrationsExport implements FromCollection, WithHeadings, WithMapping
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

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function map($registration): array
    {
        // Generate the full download all documents URL
        $downloadAllUrl = route('admin.degree_registrations.download_all', $registration->id);
        
        return [
            $registration->register_id,
            $registration->degree_program_name,
            $registration->full_name,
            $registration->name_with_initials,
            $registration->gender,
            $registration->date_of_birth,
            $registration->national_id_number,
            $registration->email,
            $registration->permanent_address,
            $registration->postal_code,
            $registration->district,
            $registration->home_contact_number,
            $registration->whatsapp_number,
            $registration->student_id,
            $registration->medium,
            $registration->guardian_name,
            $registration->guardian_contact_number,
            $registration->disability,
            $registration->passport_number,
            $registration->first_choice,
            $registration->country_residence,
            $registration->country_birth,
            $registration->nationality,
            $registration->ol_result_sheet ? asset('storage/' . $registration->ol_result_sheet) : '',
            $registration->al_result_sheet ? asset('storage/' . $registration->al_result_sheet) : '',
            $registration->id_card_copy ? asset('storage/' . $registration->id_card_copy) : '',
            $registration->it_certificate ? asset('storage/' . $registration->it_certificate) : '',
            $registration->application_form ? asset('storage/' . $registration->application_form) : '',
            $registration->passport_photo ? asset('storage/' . $registration->passport_photo) : '',
            $registration->payment_slip ? asset('storage/' . $registration->payment_slip) : '',
            $registration->created_at,
            $downloadAllUrl,
        ];
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
            'Submitted At',
            'Download All Documents (ZIP)'
        ];
    }
}
