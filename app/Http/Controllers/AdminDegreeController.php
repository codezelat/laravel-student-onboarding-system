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
}
