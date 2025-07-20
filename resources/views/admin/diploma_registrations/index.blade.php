<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diploma Registrations') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search + Filter Form --}}
            <form method="GET" action="{{ route('admin.registrations') }}" class="mb-6 flex flex-wrap gap-4 items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by Registration ID, NIC, or Name"
                    class="w-1/2 border border-gray-300 px-4 py-2 rounded"
                />

                <select name="diploma_name" class="border border-gray-300 px-4 py-2 rounded w-1/6">
                    <option value="">All Diplomas</option>
                    @foreach ($diplomas as $diploma)
                        <option value="{{ $diploma }}" {{ request('diploma_name') == $diploma ? 'selected' : '' }}>
                            {{ $diploma }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-2/6">
                    Search
                </button>

                <a href="{{ route('admin.registrations.export', request()->query()) }}"
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
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diploma</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Full Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIC</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">DOB</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">WhatsApp</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slip</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($registrations as $registration)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->register_id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->diploma_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->full_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->gender }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->national_id_number }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($registration->date_of_birth)->format('Y-m-d') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->email }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $registration->whatsapp_number }}</td>
                                <td class="px-4 py-3 text-sm text-blue-600">
                                    <a href="{{ asset('storage/' . $registration->payment_slip) }}" target="_blank" class="underline">View Slip</a>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <form method="POST" action="{{ route('admin.registrations.destroy', $registration->id) }}" onsubmit="return confirm('Are you sure you want to delete this registration?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 underline">Delete</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $registration->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-4 text-center text-gray-500 text-sm">No registrations found.</td>
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
