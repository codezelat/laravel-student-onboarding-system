<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiplomaRegistration;
use App\Exports\DiplomaRegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminDiplomaController extends Controller
{
    public function index(Request $request)
    {
        $query = DiplomaRegistration::query();

        // Search logic
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('register_id', 'like', "%{$search}%")
                  ->orWhere('national_id_number', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%");
            });
        }

        // Filter by diploma
        if ($request->filled('diploma')) {
            $query->where('diploma_name', $request->input('diploma'));
        }

        // Pagination
        $registrations = $query->orderBy('created_at', 'desc')->paginate(10);
        $registrations->appends($request->all());

        // Get diploma list
        $diplomas = DiplomaRegistration::select('diploma_name')->distinct()->pluck('diploma_name');


        return view('admin.diploma_registrations.index', compact('registrations', 'diplomas'));
    }

    public function export(Request $request)
    {
        return Excel::download(new DiplomaRegistrationsExport($request), 'registrations.xlsx');
    }

    public function destroy($id)
    {
        $registration = DiplomaRegistration::findOrFail($id);
        $registration->delete();

        return redirect()->route('admin.registrations')->with('success', 'Registration deleted successfully.');
    }

}
