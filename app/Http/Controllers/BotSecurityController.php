<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class BotSecurityController extends Controller
{
    public function decryptOrg(Request $request)
    {
        // Validate encrypted string exists
        $request->validate([
            'enc' => 'required|string'
        ]);

        try {
            // 1. Decrypt incoming encrypted org value
            $org_id = decrypt($request->enc);

            // 2. Validate that org exists
            $org = Organization::find($org_id);

            if (!$org) {
                return response()->json([
                    'success' => false,
                    'error' => 'Organization not found.'
                ], 404);
            }

            // 3. Return org_id to frontend
            return response()->json([
                'success' => true,
                'org_id' => $org_id
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => 'Invalid or tampered encrypted value.'
            ], 400);
        }
    }
}
