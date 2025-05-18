<?php

namespace App\Http\Controllers;

use App\Models\DegreeRegistration;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DegreeRegistrationController extends Controller
{
        public function create()
    {
        return view('degree_registrations.create');
    }

    public function store(Request $request)
    {
        // ✅ 1. Validate
        // Adjust validation rules based on your form requirements and database columns
        $validated = $request->validate([
            'register_id' => 'required|string|unique:degree_registrations,register_id', // Ensure unique in the NEW table
            'full_name' => 'required|string|max:255',
            'name_with_initials' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female', // Validate specific options
            'date_of_birth' => 'required|date', // Validate it's a date
            'national_id_number' => 'required|string|max:255', // Add max length
            'email' => 'required|email|max:255', // Add max length and email format
            'permanent_address' => 'required|string', // Textarea doesn't need max:255 usually
            'postal_code' => 'required|string|max:20',
            'district' => 'required|string|max:255',
            'home_contact_number' => 'nullable|string|max:20', // Optional field
            'whatsapp_number' => 'required|string|max:20', // Add max length

            // ✅ Added/Confirmed Personal & Academic Fields from your list
            'student_id' => 'required|string|max:255',
            'medium' => 'required|string|in:English,Sinhala', // Validate specific options
            'guardian_name' => 'required|string|max:255',
            'guardian_contact_number' => 'required|string|max:20',
            'disability' => 'nullable|string', // Optional field, text area like
            'country_residence' => 'required|string|max:255',
            'country_birth' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'passport_number' => 'nullable|string|max:255', // Optional field
            // Validate specific program values for the user's selected choice
            'first_choice' => 'required|string|in:Bsc.IT.&Cs.,Bsc.IT.&Cys.',

            // ✅ File Uploads Validation - Required as per form inputs
            'ol_result_sheet' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
            'al_result_sheet' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'id_card_copy' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'it_certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'application_form' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'passport_photo' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'payment_slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // ✅ 2. Map Degree Program from Register ID
        // Your new degree mapping
        $degreeMap = [
            'SITC/2025/1B/EN' => 'BA (General) in English',
            'SITC/2025/3B/PC' => 'BSc in Psychology and Counseling',
            'SITC/2025/3B/CSY' => 'BSc in Cybersecurity and Ethical Hacking',
            'SITC/2025/3B/IT' => 'BSc in Computer Science',
        ];

        $registerId = strtoupper($validated['register_id']);
        $parts = explode('/', $registerId);
        $prefix = null; // Initialize prefix

        // Logic to determine the prefix like SITC/2025/1B/EN
        if (count($parts) >= 4) {
             $streamPart = $parts[2]; // e.g., '1B', '3B'
             // Use Str::afterLast to get the code part robustly
             $programCodePart = Str::afterLast(Str::before($parts[3], '/'), preg_filter('/[^A-Z]+/i', '', $parts[3])); // Extract letters only from the 4th part (e.g., EN, PC, CSY, IT) - Refined logic
             $programCodePart = preg_replace('/[^A-Z]/i', '', $parts[3]); // Simpler regex approach

             if ($streamPart && $programCodePart) {
                  $prefix = $parts[0] . '/' . $parts[1] . '/' . $streamPart . '/' . strtoupper($programCodePart);
             }
        }

        $degreeProgramName = $degreeMap[$prefix] ?? null;

        // Check if a valid degree program name was determined from the register ID
        if (!$degreeProgramName) {
            return redirect()->back()->withInput()->withErrors(['register_id' => 'Could not determine a valid degree program name from the Register ID format.']);
        }

        // ✅ 3. Handle File Uploads
        $filePaths = [];
        $fileFields = [
            'ol_result_sheet', 'al_result_sheet', 'id_card_copy', 'it_certificate',
            'application_form', 'passport_photo', 'payment_slip'
        ];

        // Create a unique directory path based on the register ID
        $registerIdForPath = Str::slug($validated['register_id']);
        $storagePath = "degree_documents/{$registerIdForPath}";

        try {
            foreach ($fileFields as $fieldName) {
                if ($request->hasFile($fieldName)) {
                    $file = $request->file($fieldName);
                    // Store file in public storage under the unique directory
                    // store() generates a unique filename and returns the path relative to the storage disk
                    $path = $file->store($storagePath, 'public');
                    $filePaths[$fieldName] = $path; // Store the path
                }
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("File upload failed for Degree Registration ID {$registerId}: " . $e->getMessage());
            // Redirect back with an error message about file upload failure
            return redirect()->back()->withInput()->withErrors(['files' => 'One or more file uploads failed. Please check file types/sizes and try again.']);
        }

        // ✅ 4. Create New Degree Registration Record
        // Prepare data array including validated fields, derived degree name, and file paths

        $registrationData = [
            // Basic fields directly from validation
            'register_id' => $validated['register_id'],
            'full_name' => $validated['full_name'],
            'name_with_initials' => $validated['name_with_initials'],
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'national_id_number' => $validated['national_id_number'],
            'email' => $validated['email'],
            'permanent_address' => $validated['permanent_address'],
            'postal_code' => $validated['postal_code'],
            'district' => $validated['district'],
            'whatsapp_number' => $validated['whatsapp_number'],
            'student_id' => $validated['student_id'],
            'medium' => $validated['medium'],
            'guardian_name' => $validated['guardian_name'],
            'guardian_contact_number' => $validated['guardian_contact_number'],

            // Optional fields (using null coalescing operator ?? for safety, although validation nullable covers this)
            'home_contact_number' => $validated['home_contact_number'] ?? null,
            'disability' => $validated['disability'] ?? null,
             'passport_number' => $validated['passport_number'] ?? null,

            // Program Fields - Stored Separately
            'first_choice' => $validated['first_choice'], // <--- User's selected choice from the form
            'degree_program_name' => $degreeProgramName, // <--- Program name derived from the register_id
            'country_residence' => $validated['country_residence'],
            'country_birth' => $validated['country_birth'],
            'nationality' => $validated['nationality'],
        ];

        // Add the stored file paths to the registration data array
        // array_merge will add keys from $filePaths, overwriting if they somehow existed (they shouldn't)
        $registrationData = array_merge($registrationData, $filePaths);

        // Create the record in the database
        try {
            DegreeRegistration::create($registrationData);
        } catch (\Exception $e) {
             // Log database save error
             // Log::error("Failed to save Degree Registration for ID {$registerId}: " . $e->getMessage());
             // IMPORTANT: In a real application, you might want to delete the uploaded files here
             // if the database save fails to prevent orphaned files.
             // Storage::disk('public')->delete(array_values($filePaths));

            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save registration data. Please try again.']);
        }

        // ✅ 5. Redirect
        return redirect()->back()->with('success', 'Your degree registration has been submitted successfully!');
        // Or redirect to a dedicated confirmation page:
        // return redirect()->route('degree.registration.success')->with('success', 'Registration successful!');
    }
}
