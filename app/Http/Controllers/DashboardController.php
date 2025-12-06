<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
       
        $user = auth()->user();

        // If user is SUPER ADMIN → show everything
        if ($user->isSuper()) {
            $totalLeads         = \App\Models\Lead::count();
            $totalOrganizations = \App\Models\Organization::count();
            $totalQuestions     = \App\Models\BotQuestion::count();

            $latestLeads = \App\Models\Lead::latest()
                            ->take(5)
                            ->get();
        }

        // If NORMAL USER → only show assigned organization data
        else {

            $orgIds = $user->organizations->pluck('id'); // array of allowed orgs

            $totalLeads = \App\Models\Lead::whereIn('organization_id', $orgIds)->count();

            $totalOrganizations = $orgIds->count();

            $totalQuestions = \App\Models\BotQuestion::whereIn('organization_id', $orgIds)->count();

            $latestLeads = \App\Models\Lead::whereIn('organization_id', $orgIds)
                            ->latest()
                            ->take(5)
                            ->get();
        }

        return view('admin.dashboard', [
            'totalLeads'        => $totalLeads,
            'totalOrganizations'=> $totalOrganizations,
            'totalQuestions'    => $totalQuestions,
            'latestLeads'       => $latestLeads,
        ]);
    }
}

