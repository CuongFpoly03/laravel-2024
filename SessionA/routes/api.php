<?php

use App\Http\Controllers\EventAPIController;
use App\Http\Controllers\EventDetailAPIcontroller;
use App\Http\Controllers\TicketsAPIController;
use App\Http\Controllers\UserLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// gọi events
Route::get('/v1/events', [EventAPIController::class, 'index']);
Route::get('/v1/events/{id}',[EventAPIController::class, 'show']);
Route::get('v1/othertickets', [TicketsAPIController::class, 'getWorkshops']);

//login và logout
Route::get('v1/login', [UserLoginController::class, 'login']);
Route::get('v1/logout', [UserLoginController::class, 'logout']);

//
Route::get("/v1/organizers/{slug1}/events/{slug2}", [EventDetailAPIcontroller::class, "show"]);
