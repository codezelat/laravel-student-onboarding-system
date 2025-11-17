<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiplomaRegistration;

class DiplomaRegistrationController extends Controller
{
    public function create()
    {
        return view('diploma_registrations.create');
    }

    public function store(Request $request)
    {
        // ✅ FIRST: Validate
        $validated = $request->validate([
            'register_id' => 'required|string|unique:diploma_registrations',
            'full_name' => 'required|string',
            'name_with_initials' => 'required|string',
            'gender' => 'required|string',
            'national_id_number' => 'required|string',
            'date_of_birth' => 'required|date',
            'email' => 'required|email',
            'permanent_address' => 'required|string',
            'postal_code' => 'required|string',
            'district' => 'required|string',
            'home_contact_number' => 'required|string',
            'whatsapp_number' => 'required|string',
            'payment_slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // ✅ Add validation for file too (5MB max)
        ]);

        // ✅ Map diplomas
        $diplomaMap = [
            'SITC/2025/2B/EN' => 'Diploma in English',
            'SITC/2025/2B/HR' => 'Diploma in Human Resource Management and Administration',
            'SITC/2025/2B/BM' => 'Diploma in Business Management',
            'SITC/2025/2B/SC' => 'Diploma in Sociology',
            'SITC/2025/2B/PC' => 'Diploma in Psychology and Counseling',
            'SITC/2025/3B/PC' => 'Diploma in Psychology and Counseling - 3rd Batch',
            'SITC/2025/2B/IT' => 'Diploma in Information Technology',
            'SITC/2025/2B/CSY' => 'Diploma in Cybersecurity and Ethical Hacking',

            // Newly updated diplomas
            'SITC/2025/3B/EN' => 'Diploma in English - 3rd Batch',
            'SITC/2025/4B/PC' => 'Diploma in Psychology and Counseling - 4th Batch',
            'SITC/2025/3B/HR' => 'Diploma in Human Resource Management and Administration - 3rd Batch',
            'SITC/2025/2B/BM' => 'Diploma in Business Management',
            'SITC/2025/2B/IT' => 'Diploma in Information Technology',
        ];


        $registerId = strtoupper($validated['register_id']);
        $parts = explode('/', $registerId);
        if (count($parts) >= 4) {
            $prefix = $parts[0] . '/' . $parts[1] . '/' . $parts[2] . '/' . preg_replace('/[^A-Z]/', '', $parts[3]);
        } else {
            $prefix = null;
        }

        $diplomaName = $diplomaMap[$prefix] ?? null;

        if (!$diplomaName) {
            return redirect()->back()->withInput()->withErrors(['register_id' => 'Could not determine diploma name from Register ID.']);
        }

        // ✅ Now process file
        try {
            $file = $request->file('payment_slip');
            $originalName = $file->getClientOriginalName();
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);

            $path = $file->storeAs(
                'payment_slips',
                uniqid() . '.' . $extension,
                'public'
            );
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['payment_slip' => 'File upload failed. Please try again.']);
        }

        DiplomaRegistration::create([
            'register_id' => $validated['register_id'],
            'diploma_name' => $diplomaName,
            'full_name' => $validated['full_name'],
            'name_with_initials' => $validated['name_with_initials'],
            'gender' => $validated['gender'],
            'national_id_number' => $validated['national_id_number'],
            'date_of_birth' => $validated['date_of_birth'],
            'email' => $validated['email'],
            'permanent_address' => $validated['permanent_address'],
            'postal_code' => $validated['postal_code'],
            'district' => $validated['district'],
            'home_contact_number' => $validated['home_contact_number'],
            'whatsapp_number' => $validated['whatsapp_number'],
            'payment_slip' => $path,
        ]);

        return redirect()->back()->with('success', 'Your registration has been submitted successfully!');
    }

    public function show($registerId)
    {
        // Decode encoded slashes if any (e.g., SITC%2F2025%2F2B%2FEN09999 → SITC/2025/2B/EN09999)
        $registerId = urldecode($registerId);

        // Force strict match to prevent partial matches like EN09 → EN0
        $registration = DiplomaRegistration::where('register_id', '=', $registerId)->first();

        if (!$registration) {
            return redirect()->route('diploma.register.verify.form')->withErrors([
                'register_id' => 'No registration found for the Register ID: ' . $registerId
            ]);
        }

        return view('view_diploma_registrations.show', compact('registration'));
    }


    public function verifyForm()
    {
        return view('view_diploma_registrations.verify');
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'register_id' => 'required|string'
        ]);

        $exists = DiplomaRegistration::where('register_id', $validated['register_id'])->exists();

        if (!$exists) {
            return redirect()->back()->withInput()->withErrors(['register_id' => 'No registration found for this Register ID.']);
        }

        return redirect()->route('diploma.register.show', ['registerId' => $validated['register_id']]);
    }


}
