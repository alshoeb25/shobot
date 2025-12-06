<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BotQuestion;
use App\Models\Lead;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuestionController extends Controller 
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', BotQuestion::class);
       
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
        //$this->authorize('create', BotQuestion::class);
        
        $user = Auth::user();

        // Super user → all orgs
        if ($user->isSuper()) {
            $organizations = Organization::orderBy('name')->get();
        } else {
            $organizations = $user->organizations;
        }

        // Parent questions (for selected organizations)
        $parentQuestions = BotQuestion::whereIn('organization_id', $organizations->pluck('id'))
                        ->orderBy('question_text')
                        ->get();    

        return view('admin.questions.create', compact('organizations', 'parentQuestions'));
    }

    public function store(Request $request)
    {
        //$this->authorize('create', BotQuestion::class);
        
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'parent_id'       => 'nullable|exists:bot_questions,id',
            'question_text'   => 'required|string|max:255',
            'options'         => 'nullable|array',
            'order'           => 'required|integer',
        ]);

        BotQuestion::create([
            'organization_id' => $validated['organization_id'],
            'parent_id'       => $validated['parent_id'],
            'question_text'   => $validated['question_text'],
            'options'         => $validated['options'],
            'order'           => $validated['order'],
        ]);

        return redirect()->route('admin.questions.index')
                        ->with('success', 'Question created successfully.');
    }

    public function edit(BotQuestion $question)
    {
        //$this->authorize('update', $question);
        
        $user = Auth::user();

        // Super → all
        if ($user->isSuper()) {
            $organizations = Organization::orderBy('name')->get();
        } else {
            $organizations = $user->organizations;
        }

        $parentQuestions = BotQuestion::where('organization_id', $question->organization_id)
                                    ->where('id', '!=', $question->id)
                                    ->orderBy('question_text')
                                    ->get();

        return view('admin.questions.edit', compact('question', 'organizations', 'parentQuestions'));
    }

    public function update(Request $request, BotQuestion $question)
    {
        //$this->authorize('update', $question);

        // Convert options JSON string → array OR null
        if ($request->options === null || $request->options === "") {
            $request->merge(['options' => null]);
        } else {
            $decoded = json_decode($request->options, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->with('error', 'Invalid JSON in options.');
            }

            $request->merge(['options' => $decoded]);
        }

        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'parent_id'       => 'nullable|exists:bot_questions,id',
            'question_text'   => 'required|string|max:255',
            'options'         => 'nullable|array',
            'order'           => 'required|integer',
        ]);
    
        $question->update([
            'organization_id' => $validated['organization_id'],
            'parent_id'       => $validated['parent_id'],
            'question_text'   => $validated['question_text'],
            'options'         => $validated['options'],
            'order'           => $validated['order'],
        ]);

        return redirect()->route('admin.questions.index')
                        ->with('success', 'Question updated successfully.');
    }

    public function destroy(BotQuestion $question)
    {
        //$this->authorize('delete', $question);
        
        $question->delete();

        return redirect()->route('admin.questions.index')
                        ->with('success', 'Question deleted successfully.');
    }


}
