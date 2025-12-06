<div class="bg-white shadow rounded-lg overflow-hidden">

    <table class="min-w-full table-auto">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ID</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Name</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Email</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Phone</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Created</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @forelse($leads as $lead)
            <tr>
                <td class="px-6 py-4 text-sm">{{ $lead->id }}</td>
                <td class="px-6 py-4 text-sm">{{ $lead->name }}</td>
                <td class="px-6 py-4 text-sm">{{ $lead->email }}</td>
                <td class="px-6 py-4 text-sm">{{ $lead->phone }}</td>
                <td class="px-6 py-4 text-sm">{{ $lead->created_at->format('Y-m-d') }}</td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.leads.show', $lead->id) }}"
                    class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                        View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">
                    No leads found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4">
        {!! $leads->links() !!}
    </div>

</div>
