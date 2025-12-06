<?php

namespace App\Http\Controllers;

use App\Models\BotQuestion;
use Illuminate\Http\Request;

class BotQuestionController extends Controller
{
    public function index(Request $request)
    {
       
        $parentId = $request->parent_id;
        $orgId    = $request->org_id;

        $query = BotQuestion::orderBy('order');

        $query->when(isset($orgId), function ($q) use ($orgId) {
            $q->where('organization_id', $orgId);
        }, function ($q) {
            $q->whereNull('organization_id');
        });

        $query->when(isset($parentId), function ($q) use ($parentId) {
            $q->where('parent_id', $parentId);
        }, function ($q) {
            $q->whereNull('parent_id');
        });

        return response()->json($query->get());
    }
}

