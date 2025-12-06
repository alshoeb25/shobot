@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto py-10">

    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add Organization</h2>

    <form action="{{ route('admin.organizations.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow rounded-lg p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Organization Name</label>
            <input type="text" name="name" required
                   class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Logo</label>
            <input type="file" name="logo"
                   class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Theme Color</label>
            <input type="color" name="theme_color"
                   class="mt-1 block h-10 w-20 border rounded-lg shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Welcome Text</label>
            <input type="text" name="welcome_text"
                   class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
        </div>

        <button class="px-4 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700">
            Save
        </button>

    </form>

</div>

@endsection
