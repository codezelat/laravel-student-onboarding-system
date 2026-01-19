<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DegreeRegistration;
use App\Exports\DegreeRegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminDegreeController extends Controller
{
    public function index(Request $request)
    {
        $query = DegreeRegistration::query();

        // Search logic
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('register_id', 'like', "%{$search}%")
                  ->orWhere('national_id_number', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%");
            });
        }

        // Filter by degree
        if ($request->filled('degree')) {
            $query->where('degree_program_name', $request->input('degree'));
        }

        // Pagination
        $registrations = $query->orderBy('created_at', 'desc')->paginate(10);
        $registrations->appends($request->all());

        // Get degree list
        $degrees = DegreeRegistration::select('degree_program_name')->distinct()->pluck('degree_program_name');

        return view('admin.degree_registrations.index', compact('registrations', 'degrees'));
    }

    public function export(Request $request)
    {
        return Excel::download(new DegreeRegistrationsExport($request), 'degree_registrations.xlsx');
    }

    public function destroy($id)
    {
        $registration = DegreeRegistration::findOrFail($id);
        $registration->delete();

        return redirect()->route('admin.degree_registrations')->with('success', 'Registration deleted successfully.');
    }

    public function downloadAllDocuments($id)
    {
        // Find the registration
        $registration = DegreeRegistration::findOrFail($id);

        // Sanitize the register_id for use in filename
        // Remove or replace characters that are invalid in filenames
        $sanitizedRegisterId = preg_replace('/[^A-Za-z0-9_\-]/', '_', $registration->register_id);
        
        // Validate that we have a non-empty filename
        if (empty($sanitizedRegisterId)) {
            $sanitizedRegisterId = 'registration_' . $registration->id;
        }

        // Define the document fields and their display names
        $documents = [
            'ol_result_sheet' => 'OL_Result_Sheet',
            'al_result_sheet' => 'AL_Result_Sheet',
            'id_card_copy' => 'ID_Card_Copy',
            'it_certificate' => 'Diploma_Certificate',
            'application_form' => 'Application_Form',
            'passport_photo' => 'Passport_Photo',
            'payment_slip' => 'Payment_Slip',
        ];

        // Create a temporary file for the ZIP
        $zipFileName = $sanitizedRegisterId . '_documents.zip';
        $zipFilePath = storage_path('app/temp/' . $zipFileName);

        // Ensure the temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        // Create ZIP archive
        $zip = new \ZipArchive();
        
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Failed to create ZIP file');
        }

        $filesAdded = 0;

        // Add each document to the ZIP
        foreach ($documents as $field => $displayName) {
            if (!empty($registration->$field)) {
                // Try local path first
                $localPath = storage_path('app/public/' . $registration->$field);
                
                if (file_exists($localPath)) {
                    // File exists locally
                    $extension = pathinfo($localPath, PATHINFO_EXTENSION);
                    $zipEntryName = $displayName . '.' . $extension;
                    $zip->addFile($localPath, $zipEntryName);
                    $filesAdded++;
                } else {
                    // File doesn't exist locally, try to fetch from URL
                    try {
                        $fileUrl = asset('storage/' . $registration->$field);
                        
                        // Use file_get_contents with context to handle URLs
                        $context = stream_context_create([
                            'http' => [
                                'timeout' => 30,
                                'ignore_errors' => true
                            ],
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false
                            ]
                        ]);
                        
                        $fileContent = @file_get_contents($fileUrl, false, $context);
                        
                        if ($fileContent !== false && !empty($fileContent)) {
                            // Get the original file extension
                            $extension = pathinfo($registration->$field, PATHINFO_EXTENSION);
                            $zipEntryName = $displayName . '.' . $extension;
                            
                            // Add file content directly to ZIP
                            $zip->addFromString($zipEntryName, $fileContent);
                            $filesAdded++;
                        }
                    } catch (\Exception $e) {
                        // Log error but continue with other files
                        \Log::warning("Failed to add file to ZIP: " . $displayName, [
                            'error' => $e->getMessage(),
                            'field' => $field
                        ]);
                    }
                }
            }
        }

        $zip->close();

        // Check if any files were added
        if ($filesAdded === 0) {
            // Clean up the empty ZIP file
            if (file_exists($zipFilePath)) {
                unlink($zipFilePath);
            }
            return back()->with('error', 'No documents found to download');
        }

        // Download the ZIP file and delete it after sending
        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }
}
