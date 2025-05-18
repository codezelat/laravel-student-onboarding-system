@extends('layouts.simple')

@section('title', 'Student Registration Form - SITC') 

@section('page_heading', 'Diploma - Student Registration Form')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white p-5 md:p-6 relative">
            {{-- Subtle background pattern (optional) --}}
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pattern-bg" style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E');"></div>
            <h2 class="text-xl md:text-2xl font-semibold relative z-10">Student Registration Details</h2>
            <p class="mt-1 text-blue-100 text-sm relative z-10">Please fill out the form accurately.</p>
        </div>

        @if(session('success'))
        <div id="successAlert" class="mx-6 mt-6 p-4 text-sm rounded-lg flex items-center space-x-3 bg-green-100 border border-green-200" role="alert">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <span class="font-medium text-green-700">Success!</span>
                <span class="text-green-600">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        {{-- Use route() helper for action, add @csrf token --}}
        <form method="POST" action="{{ route('diploma.register.store') }}" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
            @csrf

            <div class="p-5 bg-gray-50 rounded-xl border border-gray-100 shadow-sm">
                <div class="grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-x-6">
                    <div class="md:col-span-2">
                        <label for="register_id" class="block text-sm font-medium text-gray-700 mb-1.5">Register ID <span class="text-red-500">*</span></label>
                        <div class="relative input-icon-wrapper">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                            <input type="text" name="register_id" id="register_id" value="{{ old('register_id') }}" placeholder="Enter your assigned ID (e.g., HRM01)" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" required>
                        </div>
                        @error('register_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 mt-1">Your ID should be provided in your acceptance letter.</p>
                    </div>

                    {{-- Hidden field to store the resolved diploma name --}}
                    <input type="hidden" name="diploma_name" id="diploma_name" value="{{ old('diploma_name') }}">

                    {{-- Diploma Display Area --}}
                    <div class="md:col-span-2">
                        <div id="diplomaNameContainer" class="mt-2 p-4 bg-blue-50 border border-blue-200 text-blue-800 text-sm rounded-lg transition-all duration-300 ease-in-out opacity-0 h-0 overflow-hidden" role="alert">
                            <div class="flex items-start"> {{-- Use items-start for better alignment if text wraps --}}
                                <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1v-3a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <div>
                                    <span class="font-medium">Selected Programme:</span>
                                     <span id="diplomaNameDisplay" class="ml-1">{{ old('diploma_name') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                {{-- Section Header --}}
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 mr-3">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Personal Information</h2>
                </div>
                {{-- Section Content Box --}}
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <div class="grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-x-6">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" placeholder="As per NIC/Passport" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                             @error('full_name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="name_with_initials" class="block text-sm font-medium text-gray-700 mb-1.5">Name With Initials <span class="text-red-500">*</span></label>
                            <input type="text" name="name_with_initials" id="name_with_initials" value="{{ old('name_with_initials') }}" placeholder="e.g., A. B. C. Perera" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                             @error('name_with_initials') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1.5">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="" selected disabled>Select Gender</option>
                                <option value="Male" @selected(old('gender') == 'Male')>Male</option>
                                <option value="Female" @selected(old('gender') == 'Female')>Female</option>
                            </select>
                             @error('gender') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1.5">Date of Birth <span class="text-red-500">*</span></label>
                            <div class="relative input-icon-wrapper">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" required>
                            </div>
                             @error('date_of_birth') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="national_id_number" class="block text-sm font-medium text-gray-700 mb-1.5">National ID Number <span class="text-red-500">*</span></label>
                            <input type="text" name="national_id_number" id="national_id_number" value="{{ old('national_id_number') }}" placeholder="Enter valid NIC (e.g., 95xxxxxxxV or 200xxxxxxxx)" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                             @error('national_id_number') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div>
                 {{-- Section Header --}}
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 mr-3">
                         <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Contact Information</h2>
                </div>
                 {{-- Section Content Box --}}
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <div class="grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-x-6">
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                            <div class="relative input-icon-wrapper">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="you@example.com" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" required>
                            </div>
                            @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="permanent_address" class="block text-sm font-medium text-gray-700 mb-1.5">Permanent Address <span class="text-red-500">*</span></label>
                            <textarea name="permanent_address" id="permanent_address" rows="3" placeholder="Enter your full permanent address" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>{{ old('permanent_address') }}</textarea>
                             @error('permanent_address') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1.5">Postal Code <span class="text-red-500">*</span></label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" placeholder="e.g., 10200" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                             @error('postal_code') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- Add District Dropdown --}}
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700 mb-1.5">District <span class="text-red-500">*</span></label>
                            <select name="district" id="district" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="" selected disabled>Select District</option>
                                {{-- Populate districts dynamically if possible, otherwise list them --}}
                                <option value="Ampara" @selected(old('district') == 'Ampara')>Ampara</option>
                                <option value="Anuradhapura" @selected(old('district') == 'Anuradhapura')>Anuradhapura</option>
                                <option value="Badulla" @selected(old('district') == 'Badulla')>Badulla</option>
                                <option value="Batticaloa" @selected(old('district') == 'Batticaloa')>Batticaloa</option>
                                <option value="Colombo" @selected(old('district') == 'Colombo')>Colombo</option>
                                <option value="Galle" @selected(old('district') == 'Galle')>Galle</option>
                                <option value="Gampaha" @selected(old('district') == 'Gampaha')>Gampaha</option>
                                <option value="Hambantota" @selected(old('district') == 'Hambantota')>Hambantota</option>
                                <option value="Jaffna" @selected(old('district') == 'Jaffna')>Jaffna</option>
                                <option value="Kalutara" @selected(old('district') == 'Kalutara')>Kalutara</option>
                                <option value="Kandy" @selected(old('district') == 'Kandy')>Kandy</option>
                                <option value="Kegalle" @selected(old('district') == 'Kegalle')>Kegalle</option>
                                <option value="Kilinochchi" @selected(old('district') == 'Kilinochchi')>Kilinochchi</option>
                                <option value="Kurunegala" @selected(old('district') == 'Kurunegala')>Kurunegala</option>
                                <option value="Mannar" @selected(old('district') == 'Mannar')>Mannar</option>
                                <option value="Matale" @selected(old('district') == 'Matale')>Matale</option>
                                <option value="Matara" @selected(old('district') == 'Matara')>Matara</option>
                                <option value="Monaragala" @selected(old('district') == 'Monaragala')>Monaragala</option>
                                <option value="Mullaitivu" @selected(old('district') == 'Mullaitivu')>Mullaitivu</option>
                                <option value="Nuwara Eliya" @selected(old('district') == 'Nuwara Eliya')>Nuwara Eliya</option>
                                <option value="Polonnaruwa" @selected(old('district') == 'Polonnaruwa')>Polonnaruwa</option>
                                <option value="Puttalam" @selected(old('district') == 'Puttalam')>Puttalam</option>
                                <option value="Ratnapura" @selected(old('district') == 'Ratnapura')>Ratnapura</option>
                                <option value="Trincomalee" @selected(old('district') == 'Trincomalee')>Trincomalee</option>
                                <option value="Vavuniya" @selected(old('district') == 'Vavuniya')>Vavuniya</option>
                            </select>
                             @error('district') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="home_contact_number" class="block text-sm font-medium text-gray-700 mb-1.5">Home Contact Number <span class="text-gray-400 text-xs">(Optional)</span></label>
                            <div class="relative input-icon-wrapper">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                                </div>
                                <input type="tel" name="home_contact_number" id="home_contact_number" value="{{ old('home_contact_number') }}" placeholder="e.g., 0112XXXXXX" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                            </div>
                            @error('home_contact_number') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-1.5">WhatsApp Number <span class="text-red-500">*</span></label>
                            <div class="relative input-icon-wrapper">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-1.008c-.417.11-.83.23-1.11.304L3.5 18.25l1.954-2.257c-.18-.347-.329-.714-.44-1.093C3.836 13.136 3 11.617 3 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="tel" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="e.g., 07XXXXXXXX (Active number)" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" required>
                            </div>
                            @error('whatsapp_number') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div>
                 {{-- Section Header --}}
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 mr-3">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Payment Information</h2>
                </div>
                 {{-- Section Content Box --}}
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    {{-- Payment Instructions Box --}}
                    <div class="mb-5 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1v-3a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            <div class="text-amber-700 text-sm">
                                <p class="font-medium">Payment Instructions:</p>
                                <p>Please deposit the registration only to <strong class="font-semibold">official bank accounts of SITC Campus</strong> provided by SITC support center. Upload the slip below.</p>
                            </div>
                        </div>
                    </div>

                    {{-- File Upload Input --}}
                    <div class="md:col-span-2 mb-5"> {{-- Ensure file upload is within the grid context if needed, or just full width --}}
                        <label for="payment_slip" class="block text-sm font-medium text-gray-700 mb-1.5">Upload Payment Slip <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center justify-center w-full">
                            <label for="payment_slip" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-150">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                    <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-1 text-sm text-gray-500"><span class="font-semibold text-blue-600">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG or PDF (MAX. 5MB)</p>
                                </div>
                                {{-- Actual file input is hidden --}}
                                <input id="payment_slip" name="payment_slip" type="file" class="absolute w-full h-full opacity-0 cursor-pointer" required accept=".jpg,.jpeg,.png,.pdf">

                            </label>
                        </div>
                         {{-- Display area for the selected file name --}}
                        <div id="file-name-display" class="mt-2 hidden items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                            <span class="truncate">No file selected</span>
                         </div>
                         @error('payment_slip') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Terms and Conditions Checkbox --}}
                    <div class="flex items-center pt-2">
                        <input id="terms" name="terms" type="checkbox" value="agreed" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-offset-2" required>
                        <label for="terms" class="ml-2 text-sm text-gray-700">I confirm that the information provided is accurate and I agree to the <span class="text-blue-600 hover:underline">terms and conditions</span> provided by SITC Campus via their support channels. <span class="text-red-500">*</span></label>
                    </div>
                     @error('terms') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-center pt-4">
                 <button type="submit"
                        class="text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-8 py-3 text-center transition duration-150 ease-in-out shadow-md hover:shadow-lg focus:outline-none">
                    Submit Registration
                </button>
            </div>
        </form>

        <div class="p-6 bg-gray-50 border-t border-gray-200 text-center text-sm text-gray-500">
            <p>© {{ date('Y') }} SITC Campus. All rights reserved.</p>
            <p class="mt-1">If you need assistance, please contact <a href="mailto:info@sitc.lk" class="text-blue-600 hover:underline">info@sitc.lk</a></p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Handle Register ID and Diploma Name ---
    const registerIdField = document.querySelector('#register_id');
    const diplomaNameField = document.querySelector('#diploma_name');
    const diplomaNameDisplay = document.querySelector('#diplomaNameDisplay');
    const diplomaNameContainer = document.querySelector('#diplomaNameContainer');
    const initialDiplomaName = diplomaNameField.value; // From old input

    const diplomaMap = {
        'EN': 'Diploma in English (SITC/2025/2B/EN...)',
        'HRM': 'Diploma in Human Resource Management and Administration (SITC/2025/2B/HR...)',
        'BM': 'Diploma in Business Management (SITC/2025/2B/BM...)',
        'SC': 'Diploma in Sociology (SITC/2025/2B/SC...)',
        'PC': 'Diploma in Psychology and Counseling (SITC/2025/2B/PC...)',
        'IT': 'Diploma in Information Technology (SITC/2025/2B/IT...)',
        'CSY': 'Diploma in Cybersecurity and Ethical Hacking (SITC/2025/2B/CSY...)'
    };

    function updateDiplomaDisplay(value) {
        const upperValue = value.toUpperCase();
        let foundDiplomaName = '';
        let bestMatchPrefix = '';

        for (const prefix in diplomaMap) {
            if (upperValue.startsWith(prefix) && prefix.length > bestMatchPrefix.length) {
                bestMatchPrefix = prefix;
            }
        }
        foundDiplomaName = bestMatchPrefix ? diplomaMap[bestMatchPrefix] : '';

        diplomaNameField.value = foundDiplomaName;
        diplomaNameDisplay.textContent = foundDiplomaName;

        // Show/hide the container smoothly using height and opacity
        if (foundDiplomaName) {
            if (diplomaNameContainer.classList.contains('h-0')) {
                diplomaNameContainer.classList.remove('opacity-0', 'h-0', 'overflow-hidden', 'p-0', 'border-0', 'mt-0');
                diplomaNameContainer.classList.add('opacity-100', 'p-4', 'mt-2'); // Restore styles
                // Force reflow before setting height for transition
                void diplomaNameContainer.offsetWidth;
                diplomaNameContainer.style.height = diplomaNameContainer.scrollHeight + 'px';
            }
        } else {
            if (!diplomaNameContainer.classList.contains('h-0')) {
                diplomaNameContainer.style.height = '0px';
                diplomaNameContainer.classList.remove('opacity-100');
                diplomaNameContainer.classList.add('opacity-0');

                // After transition, fully hide
                setTimeout(() => {
                    if (!diplomaNameField.value) { // Check again
                       diplomaNameContainer.classList.add('h-0', 'overflow-hidden', 'p-0', 'border-0', 'mt-0');
                       diplomaNameContainer.classList.remove('p-4', 'mt-2');
                    }
                }, 300); // Match transition duration
            }
        }
    }

    // Initial check on page load
    const initialRegisterIdValue = registerIdField.value;
     if (initialDiplomaName) {
         diplomaNameDisplay.textContent = initialDiplomaName;
         diplomaNameContainer.classList.remove('opacity-0', 'h-0', 'overflow-hidden', 'p-0', 'border-0', 'mt-0');
         diplomaNameContainer.classList.add('opacity-100', 'p-4', 'mt-2');
         // Set height after ensuring it's visible
         requestAnimationFrame(() => {
            diplomaNameContainer.style.height = diplomaNameContainer.scrollHeight + 'px';
         });
     } else if (initialRegisterIdValue) {
        updateDiplomaDisplay(initialRegisterIdValue);
    } else {
        // Ensure it starts fully hidden if no initial value
        diplomaNameContainer.classList.add('opacity-0', 'h-0', 'overflow-hidden', 'p-0', 'border-0', 'mt-0');
        diplomaNameContainer.style.height = '0px';
    }

    registerIdField.addEventListener('input', function () {
        updateDiplomaDisplay(this.value);
    });

    // --- Handle File Input Display ---
    const fileInput = document.getElementById('payment_slip');
    const fileNameDisplay = document.getElementById('file-name-display');
    const fileNameText = fileNameDisplay.querySelector('span');

    fileInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            fileNameText.textContent = this.files[0].name;
            fileNameDisplay.classList.remove('hidden');
        } else {
            fileNameText.textContent = 'No file selected';
            fileNameDisplay.classList.add('hidden');
        }
    });


});
</script>
@endpush