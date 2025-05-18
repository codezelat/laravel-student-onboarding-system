<?php

namespace App\Http\Controllers;

use App\Models\ExamPaperSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; 

class ExamPaperSubmissionController extends Controller
{
    /**
     * Display the paper submission form.
     */
    public function create()
    {
        return view('exam_paper_submissions.create');
    }

    /**
     * Store a newly created paper submission in storage.
     */
    public function store(Request $request)
    {
        $submissionType = $request->input('submission_type');

        $commonRules = [
            'lecturer_full_name' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'paper_upload' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
            'submission_type' => 'required|in:degree,diploma',
        ];

        $degreeRules = [
            'degree_name' => 'required|string|max:255',
            'degree_batch' => 'required|string|max:100',
            'degree_subject_and_code' => 'required|string|max:255',
        ];

        $diplomaRules = [
            'diploma_name' => 'required|string|max:255',
            'diploma_subject_code' => 'required|string|max:100',
            'diploma_batch' => 'required|string|max:100',
        ];

        $rules = $commonRules;
        if ($submissionType === 'degree') {
            $rules = array_merge($rules, $degreeRules);
        } elseif ($submissionType === 'diploma') {
            $rules = array_merge($rules, $diplomaRules);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $validatedData = $validator->validated();

        $dataToStore = [
            'lecturer_full_name' => $validatedData['lecturer_full_name'],
            'submission_type' => $validatedData['submission_type'],
            'exam_date' => $validatedData['exam_date'],
        ];

        if ($validatedData['submission_type'] === 'degree') {
            $dataToStore['degree_name'] = $validatedData['degree_name'];
            $dataToStore['degree_batch'] = $validatedData['degree_batch'];
            $dataToStore['degree_subject_and_code'] = $validatedData['degree_subject_and_code'];
        } elseif ($validatedData['submission_type'] === 'diploma') {
            $dataToStore['diploma_name'] = $validatedData['diploma_name'];
            $dataToStore['diploma_subject_code'] = $validatedData['diploma_subject_code'];
            $dataToStore['diploma_batch'] = $validatedData['diploma_batch'];
        }
        
        if ($request->hasFile('paper_upload')) {
            $file = $request->file('paper_upload');
            $originalFilename = $file->getClientOriginalName();
            // Store with a unique name in a private directory
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            // Store in 'storage/app/exam_papers'
            $path = $file->storeAs('exam_papers', $filename, 'local'); 
            // 'local' disk refers to storage/app by default.
            // Make sure this directory is NOT publicly accessible directly.

            $dataToStore['file_path'] = $path;
            $dataToStore['original_filename'] = $originalFilename;
            $dataToStore['mime_type'] = $file->getMimeType();
            $dataToStore['file_size'] = $file->getSize();
        }


        ExamPaperSubmission::create($dataToStore);

        return redirect()->route('exam.paper.create') // Or a different success route
                         ->with('success', 'Exam paper submitted successfully!');
    }

    public function adminIndex(Request $request)
    {
        $query = ExamPaperSubmission::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('lecturer_full_name', 'like', "%{$search}%")
                ->orWhere('degree_subject_and_code', 'like', "%{$search}%")
                ->orWhere('diploma_subject_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('submission_type')) {
            $query->where('submission_type', $request->input('submission_type'));
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(10);
        $submissions->appends($request->all());

        return view('admin.exam_paper_submissions.index', compact('submissions'));
    }

    public function adminDownload($id)
    {
        $submission = ExamPaperSubmission::findOrFail($id);

        if (!Storage::disk('local')->exists($submission->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->download($submission->file_path, $submission->original_filename);
    }

    public function destroy($id)
    {
        $submission = ExamPaperSubmission::findOrFail($id);

        // Delete the file from storage
        if (Storage::disk('local')->exists($submission->file_path)) {
            Storage::disk('local')->delete($submission->file_path);
        }

        // Delete the submission record
        $submission->delete();

        return redirect()->route('admin.exam.paper.submissions.index')
                         ->with('success', 'Submission deleted successfully.');
    }
}