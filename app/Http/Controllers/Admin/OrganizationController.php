<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrganizationController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $this->authorize('viewAny', Organization::class);

        $user = auth()->user();

        // Super admin → show all
        if ($user->isSuper()) {
            $organizations = Organization::orderBy('id', 'desc')->paginate(20);
        } else {
            // Normal user → show only assigned organizations
            $organizations = $user->organizations()->paginate(10);
        }

        
        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        $this->authorize('create', Organization::class);

        return view('admin.organizations.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Organization::class);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'logo'          => 'nullable|image|max:2048',
            'theme_color'   => 'nullable|string|max:20',
            'welcome_text'  => 'nullable|string|max:255',
        ]);

        // Store logo if uploaded
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('organizations', 'public');
        }

        Organization::create($validated);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    public function edit(Organization $organization)
    {
       
        $this->authorize('update', $organization);

        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $this->authorize('update', $organization);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'logo'          => 'nullable|image|max:2048',
            'theme_color'   => 'nullable|string|max:20',
            'welcome_text'  => 'nullable|string|max:255',
        ]);

        // If new logo uploaded, replace old
        if ($request->hasFile('logo')) {

            // Delete old if exists
            if ($organization->logo && Storage::disk('public')->exists($organization->logo)) {
                Storage::disk('public')->delete($organization->logo);
            }

            $validated['logo'] = $request->file('logo')
                ->store('organizations', 'public');
        }

        $organization->update($validated);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $this->authorize('delete', $organization);

        if ($organization->logo) {
            Storage::disk('public')->delete($organization->logo);
        }

        $organization->delete();

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }
}
