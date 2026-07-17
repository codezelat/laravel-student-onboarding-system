<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diploma Registrations') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search + Filter Form --}}
            <form method="GET" action="{{ route('admin.registrations') }}" class="mb-6 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by Registration ID, NIC, or Name"
                    class="w-full min-w-0 rounded border border-gray-300 px-4 py-2 sm:min-w-64 sm:flex-1"
                />

                <select name="diploma_name" class="w-full rounded border border-gray-300 px-4 py-2 sm:w-auto sm:min-w-56">
                    <option value="">All Diplomas</option>
                    @foreach ($diplomas as $diploma)
                        <option value="{{ $diploma }}" {{ request('diploma_name') == $diploma ? 'selected' : '' }}>
                            {{ $diploma }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="w-full rounded bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 sm:w-auto">
                    Search
                </button>

                <a href="{{ route('admin.registrations.export', request()->query()) }}"
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
                            <th class="min-w-56 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Diploma</th>
                            <th class="min-w-48 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Full Name</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Gender</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">NIC</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">DOB</th>
                            <th class="min-w-52 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Email</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">WhatsApp</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Slip</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Submitted (+05:30)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($registrations as $registration)
                            <tr class="align-top hover:bg-gray-50">
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-800">{{ $registration->register_id }}</td>
                                <td class="max-w-xs px-4 py-3 text-sm text-gray-700">{{ $registration->diploma_name }}</td>
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
                                    <form method="POST" action="{{ route('admin.registrations.destroy', $registration->id) }}" onsubmit="return confirm('Are you sure you want to delete this registration?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 underline">Delete</button>
                                    </form>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-500">{{ \App\Support\LocalDateTime::format($registration->created_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-4 py-8 text-center text-sm text-gray-500">No registrations found.</td>
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
