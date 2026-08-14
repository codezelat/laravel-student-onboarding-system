<?php

namespace App\Exports;

use App\Models\DiplomaRegistration;
use App\Support\LocalDateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DiplomaRegistrationsExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithCustomValueBinder,
    ShouldAutoSize,
    WithStyles
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

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Register ID',
            'Diploma',
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
            'Payment Slip',
            'Submitted At',
            'Last Updated At',
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->register_id,
            $registration->diploma_name,
            $registration->full_name,
            $registration->name_with_initials,
            $registration->gender,
            $this->formatDate($registration->date_of_birth),
            $registration->national_id_number,
            $registration->email,
            $registration->permanent_address,
            $registration->postal_code,
            $registration->district ?? '',
            $registration->home_contact_number,
            $registration->whatsapp_number,
            $registration->payment_slip ? asset('storage/' . $registration->payment_slip) : '',
            $this->formatDateTime($registration->created_at),
            $this->formatDateTime($registration->updated_at),
        ];
    }

    /**
     * Write every string as an explicit string cell so user input starting
     * with =, +, - or @ can never become a formula, and so broken bytes can
     * never corrupt the spreadsheet file.
     */
    public function bindValue(Cell $cell, $value): bool
    {
        if (is_string($value)) {
            $cell->setValueExplicit(self::clean($value), DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->freezePane('A2');
        $sheet->getStyle('1')->getFont()->setBold(true);
    }

    private static function clean(string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (!preg_match('//u', $value)) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        }

        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';

        if (strlen($value) > 32767) {
            $value = mb_substr($value, 0, 32767);
        }

        return $value;
    }

    private function formatDate($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return is_scalar($value) ? (string) $value : '';
        }
    }

    private function formatDateTime($value): string
    {
        try {
            return LocalDateTime::format($value, 'Y-m-d H:i:s', '');
        } catch (\Throwable $e) {
            return is_scalar($value) ? (string) $value : '';
        }
    }
}
