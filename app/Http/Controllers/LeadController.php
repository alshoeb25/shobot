<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
             'org_id' => 'required|integer|exists:organizations,id',
            'conversation' => 'required|array'
        ]);

        $data = $request->only([
            'conversation_token',
            'name',
            'email',
            'phone',
            'conversation'
        ]);
        $data['organization_id'] = $request->org_id;
        // If empty, force NULL so unique constraint does not break
        $data['conversation_token'] = $request->conversation_token ?: null;

        $lead = Lead::create($data);
        return response()->json(['success' => true, 'message' => 'Lead stored', 'lead_id' => $lead->id]);
    }
}

