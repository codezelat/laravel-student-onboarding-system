<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   <div class="mt-4">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Diploma Registrations</h4>
                        <a href="{{ route('admin.registrations') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded shadow">
                            View Diploma Registrations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   <div class="mt-4">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Degree Registrations</h4>
                        <a href="{{ route('admin.degree_registrations') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded shadow">
                            View Degree Registrations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
