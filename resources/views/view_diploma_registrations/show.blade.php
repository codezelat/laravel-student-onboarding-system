@extends('layouts.simple')

@section('title', 'Diploma Registration Details')

@section('page_heading', 'Diploma - Registration Details')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white p-6">
        <h2 class="text-xl md:text-2xl font-semibold">Student Information</h2>
    </div>

    <div class="p-6 md:p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-800">
            <div><strong>Register ID:</strong> {{ $registration->register_id }}</div>
            <div><strong>Diploma Name:</strong> {{ $registration->diploma_name }}</div>
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
        </div>
    </div>
</div>
@endsection
