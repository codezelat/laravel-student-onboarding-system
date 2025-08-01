@extends('layouts.simple')

@section('title', 'Check Degree Registration')

@section('page_heading', 'Verify Degree Registration')

@section('content')
<div class="bg-white shadow-xl rounded-xl border border-gray-200 p-8 max-w-xl mx-auto">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Enter Your Register ID</h2>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('degree.register.verify') }}" class="space-y-5">
        @csrf

        <div>
            <label for="register_id" class="block text-sm font-medium text-gray-700 mb-1">Register ID</label>
            <input type="text" name="register_id" id="register_id" value="{{ old('register_id') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 focus:border-green-500" placeholder="e.g., SITC/2025/3B/IT001" required>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-2 text-base hover:bg-green-700 transition">Check Registration</button>
        </div>
    </form>
</div>
@endsection
