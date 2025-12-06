<tr>
    <td class="px-6 py-4 text-sm text-gray-800">
        {{ $q->id }}
    </td>

    <td class="px-6 py-4 text-sm text-gray-800">
        {{ $q->organization->name ?? '' }}
    </td>

    <td class="px-6 py-4 text-sm text-gray-800">
        {{ $q->question_text }}
    </td>

    <td class="px-6 py-4 text-sm text-gray-800">
        {{ $q->parent_id ?? '-' }}
    </td>

    <td class="px-6 py-4 text-sm text-gray-700">
        <pre class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-700 whitespace-pre-wrap">
{{ json_encode($q->options) }}
        </pre>
    </td>

    <td class="px-6 py-4 text-sm text-gray-800">
        {{ $q->order }}
    </td>
    <!-- ACTIONS -->
    <td class="px-6 py-4 text-sm text-gray-800 flex gap-2">

        {{-- Edit --}}
        <a href="{{ route('admin.questions.edit', $q->id) }}"
            class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
            Edit
        </a>

        {{-- Delete --}}
        <form method="POST"
              action="{{ route('admin.questions.destroy', $q->id) }}"
              onsubmit="return confirm('Are you sure you want to delete this question?')">
            @csrf
            @method('DELETE')

            <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                Delete
            </button>
        </form>

    </td>
</tr>
