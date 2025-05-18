@extends('layouts.simple') {{-- Or your main app layout --}}

@section('title', 'Secure Paper Submission - SITC')

@section('page_heading', 'Secure Exam Paper Submission')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-3xl w-full space-y-8">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="relative">
                {{-- Optional: Logo placement area --}}
                {{-- <img src="/path/to/your/logo.png" alt="Logo" class="absolute top-4 left-6 h-12 z-20"> --}}
                
                <div class="bg-gradient-to-r from-slate-700 to-slate-600 text-white p-6 md:p-8 relative">
                    <div class="absolute top-0 left-0 w-full h-full opacity-10 pattern-bg" style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\'/%3E%3C/g%3E%3C/svg%3E');"></div>
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center relative z-10">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-semibold">@yield('page_heading')</h1>
                            <p class="mt-1 text-slate-200 text-sm">Submit exam papers securely and efficiently.</p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-4">
                            <label for="submission_type_selector" class="sr-only">Select Submission Type</label>
                            <select id="submission_type_selector" name="submission_type_selector"
                                    class="bg-slate-500 text-white border-slate-400 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg shadow-sm py-2 px-3 text-sm font-medium transition ease-in-out duration-150">
                                <option value="">Select Type...</option>
                                <option value="degree" {{ old('submission_type_selector', 'degree') == 'degree' ? 'selected' : '' }}>Degree Paper</option>
                                <option value="diploma" {{ old('submission_type_selector') == 'diploma' ? 'selected' : '' }}>Diploma Paper</option>
                            </select>
                        </div>
                    </div>
                </div>
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

            @if ($errors->any())
                <div class="mx-6 mt-6 p-4 text-sm rounded-lg bg-red-100 border border-red-200 text-red-700" role="alert">
                    <strong class="font-bold">Oops! Something went wrong.</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('exam.paper.store') }}" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8" id="paperSubmissionForm">
                @csrf
                <input type="hidden" name="submission_type" id="submission_type_hidden" value="{{ old('submission_type', 'degree') }}">

                {{-- Common Fields --}}
                <div class="p-5 bg-gray-50 rounded-xl border border-gray-100 shadow-sm">
                    <div class="grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-x-6">
                        <div class="md:col-span-2">
                            <label for="lecturer_full_name" class="block text-sm font-medium text-gray-700 mb-1.5">Lecturer's Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="lecturer_full_name" id="lecturer_full_name" value="{{ old('lecturer_full_name') }}" placeholder="Enter lecturer's full name" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            @error('lecturer_full_name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="exam_date" class="block text-sm font-medium text-gray-700 mb-1.5">Exam Date <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="date" name="exam_date" id="exam_date" value="{{ old('exam_date') }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" required>
                            </div>
                            @error('exam_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>


                {{-- Dynamic Fields Section --}}
                <div id="dynamic_fields_container">
                    {{-- Degree Fields (default or if selected) --}}
                    <div id="degree_fields" class="p-5 bg-gray-50 rounded-xl border border-gray-100 shadow-sm space-y-5">
                        <h3 class="text-md font-semibold text-gray-700 mb-3 border-b pb-2">Degree Information</h3>
                        <div>
                            <label for="degree_name" class="block text-sm font-medium text-gray-700 mb-1.5">Degree Name <span class="text-red-500">*</span></label>
                            <input type="text" name="degree_name" id="degree_name" value="{{ old('degree_name') }}" placeholder="e.g., BSc in Computer Science" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('degree_name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="degree_batch" class="block text-sm font-medium text-gray-700 mb-1.5">Degree Batch <span class="text-red-500">*</span></label>
                            <input type="text" name="degree_batch" id="degree_batch" value="{{ old('degree_batch') }}" placeholder="e.g., 2023/2024 Intake 1" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('degree_batch') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="degree_subject_and_code" class="block text-sm font-medium text-gray-700 mb-1.5">Degree Subject and Subject Code <span class="text-red-500">*</span></label>
                            <input type="text" name="degree_subject_and_code" id="degree_subject_and_code" value="{{ old('degree_subject_and_code') }}" placeholder="e.g., Programming Fundamentals - CS101" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('degree_subject_and_code') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Diploma Fields (initially hidden) --}}
                    <div id="diploma_fields" class="p-5 bg-gray-50 rounded-xl border border-gray-100 shadow-sm space-y-5" style="display: none;">
                        <h3 class="text-md font-semibold text-gray-700 mb-3 border-b pb-2">Diploma Information</h3>
                        <div>
                            <label for="diploma_name" class="block text-sm font-medium text-gray-700 mb-1.5">Diploma Name <span class="text-red-500">*</span></label>
                            <input type="text" name="diploma_name" id="diploma_name" value="{{ old('diploma_name') }}" placeholder="e.g., Diploma in Web Development" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('diploma_name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                         <div>
                            <label for="diploma_subject_code" class="block text-sm font-medium text-gray-700 mb-1.5">Subject Code <span class="text-red-500">*</span></label>
                            <input type="text" name="diploma_subject_code" id="diploma_subject_code" value="{{ old('diploma_subject_code') }}" placeholder="e.g., DWD203" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('diploma_subject_code') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="diploma_batch" class="block text-sm font-medium text-gray-700 mb-1.5">Diploma Batch <span class="text-red-500">*</span></label>
                            <input type="text" name="diploma_batch" id="diploma_batch" value="{{ old('diploma_batch') }}" placeholder="e.g., January 2024 Batch" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @error('diploma_batch') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Paper Upload Section --}}
                 <div class="p-5 bg-gray-50 rounded-xl border border-gray-100 shadow-sm">
                    <label for="paper_upload" class="block text-sm font-medium text-gray-700 mb-1.5">Upload Exam Paper <span class="text-red-500">*</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="paper_upload_input" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="paper_upload_input" name="paper_upload" type="file" class="sr-only" required accept=".pdf,.doc,.docx">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500" id="file_info">PDF, DOC, DOCX up to 10MB</p>
                        </div>
                    </div>
                    <div id="file-name-display" class="mt-2 hidden items-center text-sm text-gray-700">
                        <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        <span class="truncate">No file selected</span>
                     </div>
                    @error('paper_upload') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-center pt-4">
                    <button type="submit"
                            class="text-white bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-base px-8 py-3 text-center transition duration-150 ease-in-out shadow-md hover:shadow-lg focus:outline-none">
                        Submit Paper
                    </button>
                </div>
            </form>

             <div class="p-6 bg-gray-50 border-t border-gray-200 text-center text-sm text-gray-500">
                <p>© {{ date('Y') }} SITC Campus. All rights reserved.</p>
                <p class="mt-1">For assistance, contact <a href="mailto:info@sitc.lk" class="text-blue-600 hover:underline">info@sitc.lk</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const submissionTypeSelector = document.getElementById('submission_type_selector');
    const submissionTypeHidden = document.getElementById('submission_type_hidden');
    
    const degreeFieldsContainer = document.getElementById('degree_fields');
    const diplomaFieldsContainer = document.getElementById('diploma_fields');

    // Input fields that need to be toggled for requirement and visibility
    const degreeInputs = {
        name: document.getElementById('degree_name'),
        batch: document.getElementById('degree_batch'),
        subjectCode: document.getElementById('degree_subject_and_code'),
    };
    const diplomaInputs = {
        name: document.getElementById('diploma_name'),
        subjectCode: document.getElementById('diploma_subject_code'),
        batch: document.getElementById('diploma_batch'),
    };

    function toggleFormFields(selectedType) {
        submissionTypeHidden.value = selectedType;

        if (selectedType === 'degree') {
            degreeFieldsContainer.style.display = 'block';
            diplomaFieldsContainer.style.display = 'none';
            
            // Set degree fields as required, diploma fields as not required
            Object.values(degreeInputs).forEach(input => input.required = true);
            Object.values(diplomaInputs).forEach(input => {
                input.required = false;
                // input.value = ''; // Optionally clear diploma fields
            });

        } else if (selectedType === 'diploma') {
            degreeFieldsContainer.style.display = 'none';
            diplomaFieldsContainer.style.display = 'block';

            // Set diploma fields as required, degree fields as not required
            Object.values(diplomaInputs).forEach(input => input.required = true);
            Object.values(degreeInputs).forEach(input => {
                input.required = false;
                // input.value = ''; // Optionally clear degree fields
            });
        } else { // No type selected or invalid
            degreeFieldsContainer.style.display = 'none';
            diplomaFieldsContainer.style.display = 'none';
            Object.values(degreeInputs).forEach(input => input.required = false);
            Object.values(diplomaInputs).forEach(input => input.required = false);
        }
    }

    // Initial setup based on selector's value (or old input)
    const initialType = submissionTypeSelector.value || 'degree'; // Default to degree if nothing specific
    toggleFormFields(initialType); 
    if (submissionTypeHidden.value) { // If old input is present, it has higher precedence
        toggleFormFields(submissionTypeHidden.value);
        submissionTypeSelector.value = submissionTypeHidden.value; // Sync selector
    }


    submissionTypeSelector.addEventListener('change', function () {
        toggleFormFields(this.value);
    });

    // --- Handle File Input Display ---
    const fileInput = document.getElementById('paper_upload_input');
    const fileNameDisplayContainer = document.getElementById('file-name-display');
    const fileNameText = fileNameDisplayContainer.querySelector('span');
    const fileInfoText = document.getElementById('file_info');


    fileInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            fileNameText.textContent = this.files[0].name;
            fileNameDisplayContainer.classList.remove('hidden');
            fileNameDisplayContainer.classList.add('flex');
            fileInfoText.textContent = `Selected: ${this.files[0].name} (${(this.files[0].size / 1024 / 1024).toFixed(2)} MB)`;
        } else {
            fileNameText.textContent = 'No file selected';
            // fileNameDisplayContainer.classList.add('hidden');
            // fileNameDisplayContainer.classList.remove('flex');
            fileInfoText.textContent = 'PDF, DOC, DOCX up to 10MB';

        }
    });

    // --- Success Alert Auto Hide ---
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }, 5000); // Hide after 5 seconds
    }
});
</script>
@endpush