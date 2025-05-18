<?php

namespace App\Exports;

use App\Models\DiplomaRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class DiplomaRegistrationsExport implements FromCollection, WithHeadings
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
            'national_id_number',
            'date_of_birth',
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
            'NIC',
            'DOB',
            'Email',
            'WhatsApp',
            'Submitted At'
        ];
    }
}
