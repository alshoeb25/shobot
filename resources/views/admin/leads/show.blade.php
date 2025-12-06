@extends('layouts.admin')

@section('title', "Lead #{$lead->id}")

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- Title -->
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">
        Lead #{{ $lead->id }}
    </h3>

    <!-- Lead Information -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <p class="text-gray-700 text-lg">
            <span class="font-semibold">Name:</span> {{ $lead->name }} <br>
            <span class="font-semibold">Email:</span> {{ $lead->email }} <br>
            <span class="font-semibold">Phone:</span> {{ $lead->phone }}
        </p>
    </div>

    <!-- Conversation -->
    <h5 class="text-xl font-semibold text-gray-800 mb-3">Conversation</h5>

    <div class="bg-white rounded-lg shadow p-6">
        <ul class="space-y-3">
            @forelse($lead->conversation ?? [] as $msg)
                <li class="p-3 border border-gray-200 rounded-lg">
                    <span class="font-semibold text-indigo-700">{{ ucfirst($msg['sender']) }}:</span>
                    <span class="text-gray-700">{{ $msg['text'] }}</span>
                </li>
            @empty
                <li class="text-gray-500">No conversation available.</li>
            @endforelse
        </ul>
    </div>

</div>

@endsection
