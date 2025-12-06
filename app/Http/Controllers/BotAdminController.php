<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BotQuestion;
use App\Models\Lead;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BotAdminController extends Controller 
{
    public function index(Request $request)
    {
       
        $user = Auth::user();

        // SUPER USER → ALL ORGANIZATIONS
        if ($user->isSuper()) {
            $organizations = Organization::orderBy('name')->get();
        }
        // NORMAL USER → ONLY THEIR ORGANIZATIONS
        else {
            $organizations = $user->organizations()->orderBy('name')->get();
        }

        // If there are no organizations
        if ($organizations->isEmpty()) {
            if ($request->ajax()) {
                return response()->json(['questions' => []]);
            }

            return view('admin.questions.index', [
                'questions' => collect([]),
                'organizations' => collect([]),
                'selectedOrgId' => null,
            ]);
        }

        // Get selected organization ID (FIRST LOAD + AJAX)
        $selectedOrgId = $request->org_id ?? $organizations->first()->id;

        // FETCH QUESTIONS
        $questions = BotQuestion::with('organization')
            ->where('organization_id', $selectedOrgId)
            ->orderBy('order')
            ->get();

        // 🔥 AJAX MUST RETURN JSON BEFORE RETURN VIEW
        if ($request->ajax()) {
            return response()->json([
                'questions' => $questions
            ]);
        }

        // SHOW VIEW
        return view('admin.questions.index', [
            'questions' => $questions,
            'organizations' => $organizations,
            'selectedOrgId' => $selectedOrgId,
        ]);

    }


    public function create()
    {
        $parents = BotQuestion::pluck('question_text','id');
        return view('admin.questions.create', compact('parents'));
    }

    public function store(Request $r)
    {
        $r->validate(['question_text'=>'required']);
        BotQuestion::create([
            'organization_id' => $r->org_id ? $r->org_id : auth()->user()->organization_id,
            'question_text'=>$r->question_text,
            'field_name'=>$r->field_name,
            'type'=>$r->type ?? 'text',
            'options'=>$r->options ? json_decode($r->options,true):null,
            'parent_id'=>$r->parent_id,
            'order'=>$r->order ?? 0
        ]);
        return redirect()->route('admin.questions.index')->with('ok','Saved');
    }

    public function leads()
    {
        $orgId = auth()->user()->organization_id;

        $leads = Lead::where('organization_id', $orgId)
            ->latest()
            ->paginate(20);

        return view('admin.leads.index', compact('leads'));
    }

    public function showLead(Lead $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }
}
