<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Degree Registrations') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search + Filter Form --}}
            <form method="GET" action="{{ route('admin.degree_registrations') }}" class="mb-6 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by Registration ID, NIC, or Name"
                    class="w-full min-w-0 rounded border border-gray-300 px-4 py-2 sm:min-w-64 sm:flex-1"
                />

                <select name="degree" class="w-full rounded border border-gray-300 px-4 py-2 sm:w-auto sm:min-w-56">
                    <option value="">All Degrees</option>
                    @foreach ($degrees as $degree)
                        <option value="{{ $degree }}" {{ request('degree') == $degree ? 'selected' : '' }}>
                            {{ $degree }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="w-full rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 sm:w-auto">
                    Search
                </button>

                <a href="{{ route('admin.degree_registrations.export', request()->query()) }}"
                   class="w-full rounded bg-green-600 px-5 py-2 text-center text-white hover:bg-green-700 sm:w-auto">
                    Export to Excel
                </a>
            </form>

            {{-- Table --}}
            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-md">
                <div class="overflow-x-auto">
                <table class="w-full min-w-max divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Register ID</th>
                            <th class="min-w-56 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Degree</th>
                            <th class="min-w-48 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Full Name</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Gender</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">NIC</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">DOB</th>
                            <th class="min-w-52 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Email</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">WhatsApp</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Slip</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Details</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Submitted (+05:30)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($registrations as $index => $registration)
                            <tr x-data="{ open: false }" class="align-top hover:bg-gray-50">
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-800">{{ $registration->register_id }}</td>
                                <td class="max-w-xs px-4 py-3 text-sm text-gray-700">{{ $registration->degree_program_name }}</td>
                                <td class="max-w-xs px-4 py-3 text-sm text-gray-700">{{ $registration->full_name }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $registration->gender }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $registration->national_id_number }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($registration->date_of_birth)->format('Y-m-d') }}</td>
                                <td class="max-w-xs break-all px-4 py-3 text-sm text-gray-700">{{ $registration->email }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-700">{{ $registration->whatsapp_number }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-blue-600">
                                    <a href="{{ asset('storage/' . $registration->payment_slip) }}" target="_blank" class="underline">View Slip</a>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm">
                                    <form method="POST" action="{{ route('admin.degree_registrations.destroy', $registration->id) }}" onsubmit="return confirm('Are you sure you want to delete this registration?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 underline">Delete</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-sm text-indigo-600">
                                    <button type="button" @click="open = true" class="whitespace-nowrap underline">View More</button>
                                    <!-- Modal -->
                                    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4">
                                        <div @click.away="open = false" class="max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-xl border border-gray-200 bg-white p-5 shadow-lg sm:p-8">
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
                                                <p><strong>Dip Student ID:</strong> {{ $registration->student_id }}</p>
                                                <p><strong>Medium:</strong> {{ $registration->medium }}</p>
                                                <p><strong>First Choice:</strong> {{ $registration->first_choice }}</p>
                                                <p><strong>Disability:</strong> {{ $registration->disability ?? 'N/A' }}</p>
                                                <p><strong>Passport Number:</strong> {{ $registration->passport_number ?? 'N/A' }}</p>
                                                <p><strong>Country of Residence:</strong> {{ $registration->country_residence }}</p>
                                                <p><strong>Country of Birth:</strong> {{ $registration->country_birth }}</p>
                                                <p><strong>Nationality:</strong> {{ $registration->nationality }}</p>
                                                <p><strong>Submitted At (Colombo):</strong> {{ \App\Support\LocalDateTime::format($registration->created_at) }}</p>
                                            </div>

                                            <hr class="my-6">

                                            <h4 class="text-lg font-semibold text-gray-700 mb-3">Uploaded Documents</h4>
                                            <ul class="ml-6 list-disc space-y-1 break-words text-sm text-blue-600">
                                                <li><a href="{{ asset('storage/' . $registration->ol_result_sheet) }}" target="_blank" class="underline">O/L Result Sheet</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->al_result_sheet) }}" target="_blank" class="underline">A/L Result Sheet</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->id_card_copy) }}" target="_blank" class="underline">ID Card Copy</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->it_certificate) }}" target="_blank" class="underline">Dip Certificate</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->application_form) }}" target="_blank" class="underline">Application Form</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->passport_photo) }}" target="_blank" class="underline">Passport Photo</a></li>
                                                <li><a href="{{ asset('storage/' . $registration->payment_slip) }}" target="_blank" class="underline">Payment Slip</a></li>
                                            </ul>

                                            <div class="mt-4">
                                                <a href="{{ route('admin.degree_registrations.download_all', $registration->id) }}" 
                                                   class="inline-block rounded bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                                                    Download All Documents (ZIP)
                                                </a>
                                            </div>

                                            <div class="mt-6 text-right">
                                                <button type="button" @click="open = false" class="rounded bg-blue-700 px-5 py-2 text-white hover:bg-blue-800">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{{ \App\Support\LocalDateTime::format($registration->created_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="px-4 py-8 text-center text-sm text-gray-500">No registrations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $registrations->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>
