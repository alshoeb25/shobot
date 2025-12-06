@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto py-10">

    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Organization</h2>

    <form action="{{ route('admin.organizations.update', $organization->id) }}" 
          method="POST" enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Organization Name</label>
            <input type="text" name="name" value="{{ $organization->name }}" required
                   class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Current Logo</label>
            @if($organization->logo)
                <img src="/storage/{{ $organization->logo }}" class="h-16 w-16 object-cover rounded border mb-2">
            @endif

            <input type="file" name="logo"
                   class="block w-full border-gray-300 rounded-lg shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Theme Color</label>
            <input type="color" name="theme_color" value="{{ $organization->theme_color }}"
                   class="h-10 w-20 border rounded-lg shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Welcome Text</label>
            <input type="text" name="welcome_text" value="{{ $organization->welcome_text }}"
                   class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
        </div>

        <button class="px-4 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700">
            Update
        </button>

    </form>
    <div>
        <label class="block text-sm font-medium text-gray-700">Encrypted ID</label>
        <input type="text" readonly value="{{ encrypt($organization->id) }}"
               class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm bg-gray-100">
    </div>
</div>

@endsection
