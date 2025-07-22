@extends('layouts.simple')

@section('title', 'Student Registration Form - SITC') 

@section('page_heading', 'Degree - Student Registration Form')

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

        @if(session('error'))
        <div id="errorAlert" class="mx-6 mt-6 p-4 text-sm rounded-lg flex items-center space-x-3 bg-red-100 border border-red-200" role="alert">
            <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <span class="font-medium text-red-700">Error!</span>
                <span class="text-red-600">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        {{-- Use route() helper for action, add @csrf token --}}
        <form method="POST" action="{{ route('degree.register.store') }}" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8 bg-white shadow-md rounded-lg">
        @csrf

        {{-- Registration ID Section --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Registration Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Increased gap for better spacing --}}
                <div class="md:col-span-2">
                    <label for="register_id" class="block text-sm font-medium text-gray-700 mb-1.5">Register ID <span class="text-red-500">*</span></label>
                    <input type="text" name="register_id" id="register_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('register_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Personal Information Section --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Increased gap for better spacing --}}
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" id="full_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="name_with_initials" class="block text-sm font-medium text-gray-700 mb-1.5">Name with Initials <span class="text-red-500">*</span></label>
                    <input type="text" name="name_with_initials" id="name_with_initials" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('name_with_initials')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1.5">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" id="gender" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    @error('gender')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1.5">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('date_of_birth')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="national_id_number" class="block text-sm font-medium text-gray-700 mb-1.5">National ID Number <span class="text-red-500">*</span></label>
                    <input type="text" name="national_id_number" id="national_id_number" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('national_id_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                {{-- Added/Confirmed from new requirements --}}
                <div>
                    <label for="passport_number" class="block text-sm font-medium text-gray-700 mb-1.5">Passport Number (if available)</label>
                    <input type="text" name="passport_number" id="passport_number" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                    @error('passport_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="nationality" class="block text-sm font-medium text-gray-700 mb-1.5">Nationality <span class="text-red-500">*</span></label>
                    <input type="text" name="nationality" id="nationality" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('nationality')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="country_birth" class="block text-sm font-medium text-gray-700 mb-1.5">Country of Birth <span class="text-red-500">*</span></label>
                    <input type="text" name="country_birth" id="country_birth" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('country_birth')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="country_residence" class="block text-sm font-medium text-gray-700 mb-1.5">Country of Permanent Residence <span class="text-red-500">*</span></label>
                    <input type="text" name="country_residence" id="country_residence" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('country_residence')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="disability" class="block text-sm font-medium text-gray-700 mb-1.5">Disability / Special Needs</label>
                    <input type="text" name="disability" id="disability" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                    @error('disability')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Contact Information Section --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Increased gap for better spacing --}}
                <div>
                    <label for="permanent_address" class="block text-sm font-medium text-gray-700 mb-1.5">Permanent Address <span class="text-red-500">*</span></label>
                    <textarea name="permanent_address" id="permanent_address" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" rows="3" required></textarea>
                    @error('permanent_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="district" class="block text-sm font-medium text-gray-700 mb-1.5">District <span class="text-red-500">*</span></label>
                    <input type="text" name="district" id="district" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('district')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1.5">Postal Code <span class="text-red-500">*</span></label>
                    <input type="text" name="postal_code" id="postal_code" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('postal_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-1.5">WhatsApp Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="whatsapp_number" id="whatsapp_number" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('whatsapp_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="home_contact_number" class="block text-sm font-medium text-gray-700 mb-1.5">Home Contact Number</label>
                    <input type="tel" name="home_contact_number" id="home_contact_number" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                    @error('home_contact_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Academic Information Section --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Academic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Increased gap for better spacing --}}
                {{-- Added/Confirmed from new requirements --}}
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1.5">Diploma Student ID (e.g., CBC 100, DIT 100) <span class="text-red-500">*</span></label>
                    <input type="text" name="student_id" id="student_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('student_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="medium" class="block text-sm font-medium text-gray-700 mb-1.5">Medium <span class="text-red-500">*</span></label>
                    <select name="medium" id="medium" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                        <option value="">Select Medium</option>
                        <option value="English">English</option>
                        <option value="Sinhala">Sinhala</option>
                    </select>
                    @error('medium')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="guardian_name" class="block text-sm font-medium text-gray-700 mb-1.5">Guardian Name <span class="text-red-500">*</span></label>
                    <input type="text" name="guardian_name" id="guardian_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('guardian_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="guardian_contact_number" class="block text-sm font-medium text-gray-700 mb-1.5">Guardian Contact Number <span class="text-red-500">*</span></label>
                    <input type="text" name="guardian_contact_number" id="guardian_contact_number" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                    @error('guardian_contact_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                {{-- Updated 1st Choice to select dropdown --}}
                <div>
                    <label for="first_choice" class="block text-sm font-medium text-gray-700 mb-1.5">1st Choice <span class="text-red-500">*</span></label>
                    <select name="first_choice" id="first_choice" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2" required>
                        <option value="">Select Program</option>
                        <option value="BA (general) in english">BA (general) in english</option>
                        <option value="BSC in psychology and counseling">BSC in psychology and counseling</option>
                        <option value="BSc in cyber security and ethical hacking">BSc in cyber security and ethical hacking</option>
                        <option value="BSc in computer science">BSc in computer science</option> 
                        <option value="BSc in HRM and BS">BSc in HRM and BS</option>
                    </select>
                    @error('first_choice')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- File Uploads Section --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Required Documents</h3>
            <p class="text-sm text-gray-600 mb-4">Please upload scanned copies of the following documents. (Accepted formats: PDF, JPG, PNG)</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> {{-- Increased gap for better spacing --}}
                @php
                    $fileFields = [
                        'ol_result_sheet' => 'OL Result Sheet',
                        'al_result_sheet' => 'A/L Result Sheet',
                        'id_card_copy' => 'ID Card Copy',
                        'it_certificate' => 'Diploma Certificate',
                        'application_form' => 'Application Form (PSBU Application)',
                        'passport_photo' => 'Passport Size Photo (2x2 inch)',
                        'payment_slip' => 'Payment Slip', // Included as it was in your original loop
                    ];
                @endphp

                @foreach($fileFields as $fieldName => $fieldLabel)
                    <div>
                        <label for="{{ $fieldName }}" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $fieldLabel }} <span class="text-red-500">*</span></label>
                        <input type="file" name="{{ $fieldName }}" id="{{ $fieldName }}" class="w-full border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                        @error($fieldName)<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>
        </div>


        <div class="pt-6">
            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Submit Application</button>
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