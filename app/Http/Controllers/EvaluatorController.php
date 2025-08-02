<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PolicyService;
use Illuminate\Http\Request;

class EvaluatorController extends Controller
{
    protected PolicyService $policyService;

    public function __construct(PolicyService $policyService)
    {
        $this->policyService = $policyService;
    }

    public function index()
    {
        return view('rule-evaluator', [
            'users'=> User::all()
        ]);
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|string|in:submit_form,create_content,delete_content,view_reports',
        ]);

        $user = User::find($validated['user_id']);
        $action = $validated['action'];

        if (!$user) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }
        
        // Check if user can submit form
        if (!$this->policyService->can($user, $action)) {
            return response()->json([
                'error' => 'You do not have permission to perform this action',
                'required' => 'Staff role and verified email'
            ], 403);
        }

        // Process form submission...
        return response()->json(['message' => 'Form submitted successfully!'], 200);
    }
}
