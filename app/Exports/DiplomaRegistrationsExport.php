<?php

namespace App\Exports;

use App\Models\DiplomaRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use App\Support\LocalDateTime;

class DiplomaRegistrationsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = DiplomaRegistration::query();

        if ($this->request->filled('search')) {
            $search = $this->request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('register_id', 'like', "%{$search}%")
                  ->orWhere('national_id_number', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('diploma_name')) {
            $query->where('diploma_name', $this->request->input('diploma_name'));
        }

        return $query->orderBy('created_at', 'desc')->get([
            'register_id',
            'diploma_name',
            'full_name',
            'name_with_initials',
            'national_id_number',
            'date_of_birth',
            'gender',
            'email',
            'whatsapp_number',
            'created_at'
        ]);
    }

    public function headings(): array
    {
        return [
            'Register ID',
            'Diploma',
            'Full Name',
            'Name with Initials',
            'NIC',
            'DOB',
            'Gender',
            'Email',
            'WhatsApp',
            'Submitted At'
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->register_id,
            $registration->diploma_name,
            $registration->full_name,
            $registration->name_with_initials,
            $registration->national_id_number,
            $registration->date_of_birth,
            $registration->gender,
            $registration->email,
            $registration->whatsapp_number,
            LocalDateTime::format($registration->created_at, 'Y-m-d H:i:s', ''),
        ];
    }
}
