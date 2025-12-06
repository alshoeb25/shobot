@extends('layouts.admin')

@section('title', 'Leads')

@section('content')

<div class="max-w-7xl mx-auto">

    <h3 class="text-2xl font-semibold mb-4">Leads</h3>

    <!-- Organization dropdown -->
    <div class="mb-4">
        <label class="block mb-1 font-medium">Select Organization</label>

        <select id="leadOrgFilter" class="border rounded px-3 py-2">
            @foreach($organizations as $org)
                <option value="{{ $org->id }}" {{ $selectedOrgId == $org->id ? 'selected' : '' }}>
                    {{ $org->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div id="leadTableWrapper">
        @include('admin.leads.partials.table', ['leads' => $leads])
    </div>

</div>

@endsection

@section('scripts')
<script>
    console.log('Lead filtering script loaded.');
document.addEventListener('DOMContentLoaded', function () {
    const orgSelect = document.getElementById('leadOrgFilter');

    orgSelect.addEventListener('change', function () {
        loadLeads(this.value);
    });

    // Handle pagination clicks
    document.addEventListener('click', function (e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            let url = e.target.getAttribute('href');
            loadLeads(orgSelect.value, url);
        }
    });

    function loadLeads(orgId, url = null) {
        let fetchUrl = url ?? ("{{ route('admin.leads.index') }}?org_id=" + orgId);

        fetch(fetchUrl, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('leadTableWrapper').innerHTML = data.html;
        });
    }
});
</script>
@endsection
