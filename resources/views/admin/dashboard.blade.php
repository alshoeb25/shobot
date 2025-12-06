@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Total Leads -->
        <div class="bg-blue-600 text-white rounded-xl shadow p-6">
            <h5 class="text-lg font-semibold">Total Leads</h5>
            <h3 class="text-3xl font-bold mt-2">{{ $totalLeads }}</h3>
        </div>

        <!-- Organizations -->
        <div class="bg-green-600 text-white rounded-xl shadow p-6">
            <h5 class="text-lg font-semibold">Organizations</h5>
            <h3 class="text-3xl font-bold mt-2">{{ $totalOrganizations }}</h3>
        </div>

        <!-- Questions -->
        <div class="bg-indigo-600 text-white rounded-xl shadow p-6">
            <h5 class="text-lg font-semibold">Questions</h5>
            <h3 class="text-3xl font-bold mt-2">{{ $totalQuestions }}</h3>
        </div>

    </div>

    <!-- Latest Leads -->
    <div class="bg-white shadow rounded-xl mt-10 overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Latest Leads</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-sm font-semibold">Name</th>
                        <th class="px-6 py-3 text-sm font-semibold">Email</th>
                        <th class="px-6 py-3 text-sm font-semibold">Phone</th>
                        <th class="px-6 py-3 text-sm font-semibold">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y">

                    @foreach($latestLeads as $lead)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $lead->name }}</td>
                            <td class="px-6 py-3">{{ $lead->email }}</td>
                            <td class="px-6 py-3">{{ $lead->phone }}</td>
                            <td class="px-6 py-3">{{ $lead->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
