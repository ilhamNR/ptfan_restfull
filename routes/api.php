<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\User\PresenceController;
use App\Http\Controllers\API\Supervisor\ApprovalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Login route
Route::post('/login', [LoginController::class, 'login']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // User presence route
    Route::post('/presence', [PresenceController::class, 'presence']);

    // Supervisor approval route
    Route::post('/approve-presence', [ApprovalController::class, 'approvePresence']);

    // Logout route
    Route::post('/logout', [LoginController::class, 'logout']);
});

// Default route for retrieving user data
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
