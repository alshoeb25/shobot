@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Organizations</h2>
        @can('create', App\Models\Organization::class)
        <a href="{{ route('admin.organizations.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-sm">
            + Add Organization
        </a>
        @endcan
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="min-w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Logo</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Theme Color</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Welcome Text</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach ($organizations as $org)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $org->id }}</td>

                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                        {{ $org->name }}
                    </td>

                    <td class="px-6 py-4">
                        @if($org->logo)
                            <img src="/storage/{{ $org->logo }}" class="h-12 w-12 rounded object-cover border">
                        @else
                            <span class="text-gray-400 text-sm">No Logo</span>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-white rounded shadow"
                              style="background: {{ $org->theme_color }}">
                            {{ $org->theme_color }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $org->welcome_text }}
                    </td>

                    <td class="px-6 py-4 flex space-x-2">
                        @can('create', $org)
                        <a href="{{ route('admin.organizations.edit', $org->id) }}"
                           class="px-3 py-1 bg-yellow-500 text-white rounded shadow hover:bg-yellow-600">
                            Edit
                        </a>
                        @endcan

                        @can('delete', $org)
                        <form action="{{ route('admin.organizations.destroy', $org->id) }}"
                              method="POST" onsubmit="return confirm('Delete this organization?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-3 py-1 bg-red-600 text-white rounded shadow hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                        @endcan

                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="mt-6">
        {{ $organizations->links() }}
    </div>

</div>

@endsection
