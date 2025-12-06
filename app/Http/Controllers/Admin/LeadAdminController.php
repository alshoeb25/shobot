<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BotQuestion;
use App\Models\Lead;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadAdminController extends Controller 
{
    public function index(Request $request)
    {
       
       $user = Auth::user();

        // 1. Allowed organizations
        if ($user->isSuper()) {
            $organizations = Organization::orderBy('name')->get();
        } else {
            $organizations = $user->organizations()->orderBy('name')->get();
        }

        // First org selected by default
        $selectedOrgId = $request->org_id ?? ($organizations->first()->id ?? null);

        // 2. Query leads
        $query = Lead::query()->where('organization_id', $selectedOrgId);

        // Pagination
        $leads = $query->orderBy('id', 'desc')->paginate(10);

        // 3. AJAX pagination support
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.leads.partials.table', compact('leads'))->render(),
                'pagination' => (string) $leads->links(),
            ]);
        }

        return view('admin.leads.index', [
            'organizations' => $organizations,
            'selectedOrgId' => $selectedOrgId,
            'leads'         => $leads,
        ]);
    }


    public function showLead(Lead $lead)
    {

        return view('admin.leads.show', [
            'lead' => $lead,
        ]);
    }

}
