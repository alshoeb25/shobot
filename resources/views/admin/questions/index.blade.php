@extends('layouts.admin')

@section('title', 'Bot Questions')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-semibold text-gray-800">Bot Questions</h3>

        <div class="flex gap-2">

            <!-- Create Button -->
            <a href="{{ route('admin.questions.create') }}"
            class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg shadow hover:bg-green-700 transition">
                + Create Question
            </a>

            <!-- Refresh Button -->
            <a href="{{ route('admin.questions.index') }}"
            class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg shadow hover:bg-indigo-700 transition">
                Refresh
            </a>

        </div>
    </div>

    {{-- Organization Dropdown --}}
    @if($organizations->count())
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Select Organization
        </label>
        <select id="orgFilter"
                class="px-3 py-2 border rounded-lg text-sm">
            @foreach($organizations as $org)
                <option value="{{ $org->id }}" {{ $selectedOrgId == $org->id ? 'selected' : '' }}>
                    {{ $org->name }}
                </option>
            @endforeach
        </select>
    </div>
    @else
        <div class="mb-4 text-sm text-red-600">
            No organizations assigned to your account.
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden mt-4">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Organization</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Question</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Parent</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Options</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Order</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Actions</th>

                </tr>
            </thead>

            <tbody id="questionsTable" class="divide-y divide-gray-200">
                @forelse($questions as $q)
                    @include('admin.questions.row', ['q' => $q])
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No questions found for this organization.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection

@section('scripts')
<script>
    console.log("Script Loaded befrore DOMContentLoaded");
document.addEventListener('DOMContentLoaded', function () {
    console.log("Script Loaded");
    const orgFilter = document.getElementById('orgFilter');
    if (!orgFilter) return;

    orgFilter.addEventListener('change', function () {
        let orgId = this.value;

        fetch("{{ route('admin.questions.index') }}?org_id=" + orgId, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(res => res.json())
        .then(data => {
            let tbody = document.getElementById('questionsTable');
            tbody.innerHTML = "";

            if (!data.questions.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No questions found for this organization.
                        </td>
                    </tr>
                `;
                return;
            }

            data.questions.forEach(q => {
                tbody.innerHTML += `
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">${q.id}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">${q.organization ? q.organization.name : ''}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">${q.question_text}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">${q.parent_id ?? '-'}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <pre class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-700 whitespace-pre-wrap">
${JSON.stringify(q.options ?? [])}
                            </pre>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">${q.order}</td>
                        <td class="px-6 py-4 text-sm flex gap-2">

                            <!-- Edit Button -->
                            <a href="/admin/questions/${q.id}/edit"
                            class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                                Edit
                            </a>

                            <!-- Delete Button -->
                            <form method="POST"
                                action="/admin/questions/${q.id}"
                                onsubmit="return confirm('Delete this question?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                `;
            });
        });
    });
});
</script>
@endsection
