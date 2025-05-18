<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Degree Registrations') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search + Filter Form --}}
            <form method="GET" action="{{ route('admin.degree_registrations') }}" class="mb-6 flex flex-wrap gap-4 items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by Registration ID, NIC, or Name"
                    class="w-1/2 border border-gray-300 px-4 py-2 rounded"
                />

                <select name="degree" class="border border-gray-300 px-4 py-2 rounded w-1/6">
                    <option value="">All Degrees</option>
                    @foreach ($degrees as $degree)
                        <option value="{{ $degree }}" {{ request('degree') == $degree ? 'selected' : '' }}>
                            {{ $degree }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-2/6">
                    Search
                </button>

                <a href="{{ route('admin.degree_registrations.export', request()->query()) }}"
                   class="bg-green-600 hover:bg-green-700 text-white text-center px-4 py-2 rounded w-2/6">
                    Export to Excel
                </a>
            </form>

            {{-- Table --}}
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Register ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Degree</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Full Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIC</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">DOB</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">WhatsApp</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slip</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($registrations as $index => $registration)
                            <tr x-data="{ open: false }">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->register_id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->degree_program_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->full_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->national_id_number }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($registration->date_of_birth)->format('Y-m-d') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->email }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->whatsapp_number }}</td>
                                <td class="px-4 py-3 text-sm text-blue-600">
                                    <a href="{{ asset('storage/' . $registration->payment_slip) }}" target="_blank" class="underline">View</a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $registration->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <form method="POST" action="{{ route('admin.degree_registrations.destroy', $registration->id) }}" onsubmit="return confirm('Are you sure you want to delete this registration?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 underline">Delete</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-sm text-indigo-600">
                                    <button @click="open = true" class="underline">View More</button>
                                    <!-- Modal -->
                                    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
                                        <div @click.away="open = false" class="bg-white w-full max-w-4xl rounded-xl shadow-lg p-8 overflow-y-auto max-h-[90vh] border border-gray-200">
                                            <h3 class="text-2xl font-bold text-blue-700 mb-6">Full Registration Details</h3>

                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-black">
                                                <p><strong>Register ID:</strong> {{ $registration->register_id }}</p>
                                                <p><strong>Degree Program:</strong> {{ $registration->degree_program_name }}</p>
                                                <p><strong>Full Name:</strong> {{ $registration->full_name }}</p>
                                                <p><strong>Name with Initials:</strong> {{ $registration->name_with_initials }}</p>
                                                <p><strong>Gender:</strong> {{ $registration->gender }}</p>
                                                <p><strong>Date of Birth:</strong> {{ $registration->date_of_birth }}</p>
                                                <p><strong>NIC:</strong> {{ $registration->national_id_number }}</p>
                                                <p><strong>Email:</strong> {{ $registration->email }}</p>
                                                <p><strong>WhatsApp:</strong> {{ $registration->whatsapp_number }}</p>
                                                <p><strong>Home Contact:</strong> {{ $registration->home_contact_number ?? 'N/A' }}</p>
                                                <p><strong>Guardian Name:</strong> {{ $registration->guardian_name }}</p>
                                                <p><strong>Guardian Contact:</strong> {{ $registration->guardian_contact_number }}</p>
                                                <p><strong>Permanent Address:</strong> {{ $registration->permanent_address }}</p>
                                                <p><strong>Postal Code:</strong> {{ $registration->postal_code }}</p>
                                                <p><strong>District:</strong> {{ $registration->district }}</p>
                                                <p><strong>Student ID:</strong> {{ $registration->student_id }}</p>
                                                <p><strong>Medium:</strong> {{ $registration->medium }}</p>
                                                <p><strong>First Choice:</strong> {{ $registration->first_choice }}</p>
                                                <p><strong>Disability:</strong> {{ $registration->disability ?? 'N/A' }}</p>
                                                <p><strong>Passport Number:</strong> {{ $registration->passport_number ?? 'N/A' }}</p>
                                                <p><strong>Country of Residence:</strong> {{ $registration->country_residence }}</p>
                                                <p><strong>Country of Birth:</strong> {{ $registration->country_birth }}</p>
                                                <p><strong>Nationality:</strong> {{ $registration->nationality }}</p>
                                                <p><strong>Submitted At:</strong> {{ $registration->created_at->format('Y-m-d H:i') }}</p>
                                            </div>

                                            <hr class="my-6">

                                            <h4 class="text-lg font-semibold text-gray-700 mb-3">Uploaded Documents</h4>
                                            <ul class="list-disc ml-6 space-y-1 text-blue-600 text-sm">
                                                <li><a href="{{ asset('storage/' . $registration->ol_result_sheet) }}" target="_blank" class="underline">O/L Result Sheet</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->al_result_sheet) }}" target="_blank" class="underline">A/L Result Sheet</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->id_card_copy) }}" target="_blank" class="underline">ID Card Copy</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->it_certificate) }}" target="_blank" class="underline">IT Certificate</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->application_form) }}" target="_blank" class="underline">Application Form</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->passport_photo) }}" target="_blank" class="underline">Passport Photo</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->payment_slip) }}" target="_blank" class="underline">Payment Slip</a></li>
                                            </ul>

                                            <div class="mt-6 text-right">
                                                <button @click="open = false" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                    
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-4 text-center text-gray-500 text-sm">No registrations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $registrations->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>
