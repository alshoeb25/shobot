@extends('layouts.admin')

@section('title', 'Create Question')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

    <form method="POST" action="{{ route('admin.questions.store') }}">
        @csrf

        <!-- Organization -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Organization</label>
            <select name="organization_id" class="w-full border px-3 py-2 rounded">
                @foreach($organizations as $org)
                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Parent Question -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Parent Question (optional)</label>
            <select name="parent_id" class="w-full border px-3 py-2 rounded">
                <option value="">None</option>

                @foreach($parentQuestions as $p)
                    <option value="{{ $p->id }}">{{ $p->question_text }}</option>
                @endforeach
            </select>
        </div>

        <!-- Question Text -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Question Text</label>
            <input type="text" name="question_text" class="w-full border px-3 py-2 rounded" required>
        </div>

        <!-- Options (json array) -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Options (JSON)</label>
            <textarea name="options" class="w-full border px-3 py-2 rounded" placeholder='["Yes","No"]'></textarea>
        </div>

        <!-- Order -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Order</label>
            <input type="number" name="order" class="w-full border px-3 py-2 rounded" value="0">
        </div>

        <button class="px-4 py-2 bg-green-600 text-white rounded">Create</button>
    </form>

</div>

@endsection
