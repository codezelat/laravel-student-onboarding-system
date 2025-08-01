@extends('layouts.simple')

@section('title', 'Degree Registration Details')

@section('page_heading', 'Degree - Registration Details')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-green-600 to-green-500 text-white p-6">
        <h2 class="text-xl md:text-2xl font-semibold">Student Information</h2>
    </div>

    <div class="p-6 md:p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-800">
            <div><strong>Register ID:</strong> {{ $registration->register_id }}</div>
            <div><strong>Degree Name:</strong> {{ $registration->degree_program_name }}</div>
            <div><strong>Full Name:</strong> {{ $registration->full_name }}</div>
            <div><strong>Name with Initials:</strong> {{ $registration->name_with_initials }}</div>
            <div><strong>Gender:</strong> {{ $registration->gender }}</div>
            <div><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($registration->date_of_birth)->format('d M Y') }}</div>
            <div><strong>NIC Number:</strong> {{ $registration->national_id_number }}</div>
            <div><strong>Email:</strong> {{ $registration->email }}</div>
            <div class="md:col-span-2"><strong>Permanent Address:</strong> {{ $registration->permanent_address }}</div>
            <div><strong>Postal Code:</strong> {{ $registration->postal_code }}</div>
            <div><strong>District:</strong> {{ $registration->district }}</div>
            <div><strong>Home Contact Number:</strong> {{ $registration->home_contact_number ?? '—' }}</div>
            <div><strong>WhatsApp Number:</strong> {{ $registration->whatsapp_number }}</div>
            <div><strong>Student ID:</strong> {{ $registration->student_id }}</div>
            <div><strong>Medium:</strong> {{ $registration->medium }}</div>
            <div><strong>First Choice:</strong> {{ $registration->first_choice }}</div>
            <div><strong>Guardian Name:</strong> {{ $registration->guardian_name }}</div>
            <div><strong>Guardian Contact:</strong> {{ $registration->guardian_contact_number }}</div>
            <div><strong>Country of Residence:</strong> {{ $registration->country_residence }}</div>
            <div><strong>Country of Birth:</strong> {{ $registration->country_birth }}</div>
            <div><strong>Nationality:</strong> {{ $registration->nationality }}</div>
            <div><strong>Passport Number:</strong> {{ $registration->passport_number ?? '—' }}</div>
            <div><strong>Disability:</strong> {{ $registration->disability ?? '—' }}</div>
        </div>
    </div>
</div>
@endsection
