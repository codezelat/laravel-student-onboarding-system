<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exam Paper Submissions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('admin.exam.index') }}" class="mb-6 flex flex-wrap gap-4 items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by Lecturer or Subject Code"
                    class="w-1/2 border border-gray-300 px-4 py-2 rounded"
                />

                <select name="submission_type" class="border border-gray-300 px-4 py-2 rounded w-1/6">
                    <option value="">All Types</option>
                    <option value="degree" {{ request('submission_type') == 'degree' ? 'selected' : '' }}>Degree</option>
                    <option value="diploma" {{ request('submission_type') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                </select>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-2/6">
                    Search
                </button>
            </form>

            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lecturer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject / Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Exam Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Download</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($submissions as $submission)
                            <tr x-data="{ open: false }">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $submission->lecturer_full_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 capitalize">{{ $submission->submission_type }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $submission->submission_type === 'degree' ? $submission->degree_subject_and_code : $submission->diploma_subject_code }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $submission->submission_type === 'degree' ? $submission->degree_batch : $submission->diploma_batch }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($submission->exam_date)->format('Y-m-d') }}</td>
                                <td class="px-4 py-3 text-sm text-blue-600">
                                    <a href="{{ route('admin.exam.download', $submission->id) }}" target="_blank" class="underline">Download</a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-3 text-sm text-indigo-600">
                                    <button @click="open = true" class="underline">View More</button>
                                    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
                                        <div @click.away="open = false" class="bg-white w-full max-w-4xl rounded-xl shadow-lg p-8 overflow-y-auto max-h-[90vh] border border-gray-200">
                                            <h3 class="text-2xl font-bold text-blue-700 mb-6">Full Submission Details</h3>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-black">
                                                <p><strong>Lecturer:</strong> {{ $submission->lecturer_full_name }}</p>
                                                <p><strong>Type:</strong> {{ $submission->submission_type }}</p>
                                                <p><strong>Exam Date:</strong> {{ $submission->exam_date }}</p>
                                                <p><strong>Batch:</strong> {{ $submission->submission_type === 'degree' ? $submission->degree_batch : $submission->diploma_batch }}</p>
                                                <p><strong>Subject:</strong> {{ $submission->submission_type === 'degree' ? $submission->degree_subject_and_code : $submission->diploma_subject_code }}</p>
                                                <p><strong>Program Name:</strong> {{ $submission->submission_type === 'degree' ? $submission->degree_name : $submission->diploma_name }}</p>
                                                <p><strong>Original Filename:</strong> {{ $submission->original_filename }}</p>
                                                <p><strong>File Type:</strong> {{ $submission->mime_type }}</p>
                                                <p><strong>File Size:</strong> {{ number_format($submission->file_size / 1024, 2) }} KB</p>
                                                <p><strong>Submitted:</strong> {{ $submission->created_at->format('Y-m-d H:i') }}</p>
                                            </div>
                                            <hr class="my-6">
                                            <div class="mt-4">
                                                <a href="{{ route('admin.exam.download', $submission->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mr-3">Download File</a>
                                                <button @click="open = false" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-4 text-center text-gray-500 text-sm">No submissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $submissions->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>