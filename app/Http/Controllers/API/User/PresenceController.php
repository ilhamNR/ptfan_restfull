<?php

namespace App\Http\Controllers\API\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Epresence;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class PresenceController extends Controller
{
    public function presence()
    {
        try {
            // Get the current user from the session
            $userSession = Auth::user();

            // Check the last presence data
            $lastPresenceData = Epresence::where('id_user', $userSession->id)->latest()->first();

            // Determine the presence type (IN or OUT)
            $presenceType = ($lastPresenceData && $lastPresenceData->type == 'IN') ? 'OUT' : 'IN';

            DB::beginTransaction();

            // Create new presence record
            $data = Epresence::create([
                'id_users' => $userSession->id,
                'type' => $presenceType,
                'is_approve' => false,
                'waktu' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::commit();

            // Return the created presence data as JSON response
            return response()->json($data, 200);
        } catch (\Exception $e) {
            // Rollback transaction in case of exception
            DB::rollBack();

            // Return error response if any exception occurs
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    public function getData()
    {
        try {
            // Get the current user from the session
            $userSession = Auth::user();

            // Retrieve presence data for the current user
            $data = Epresence::where('id_user', $userSession->id)->get();

            // Return the presence data as JSON response
            return response()->json($data, 200);
        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
