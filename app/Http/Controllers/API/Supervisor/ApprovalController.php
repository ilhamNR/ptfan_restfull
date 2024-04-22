<?php

namespace App\Http\Controllers\API\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Epresence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function approvePresence(Request $request)
{
    try {
        // Get the current user from the session
        $userSession = Auth::user();

        // Find the presence data by ID or throw a 404 error
        $presenceData = Epresence::findOrFail($request->id);

        // Check if the current user is the supervisor of the presence data owner
        if ($userSession->npp == $presenceData->users->npp_supervisor) {
            // Start a database transaction
            DB::beginTransaction();

            // Update the presence data to mark it as approved
            $presenceData->update([
                'is_approve' => true
            ]);

            // Commit the transaction
            DB::commit();
        } else {
            // Return a response indicating that the current user is not the supervisor
            return response()->json('Anda bukan supervisor dari akun ini', 401);
        }
    } catch (\Exception $e) {
        // Return error response if any exception occurs
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}
}
