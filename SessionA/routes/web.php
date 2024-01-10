<?php

use App\Http\Controllers\ChannelsController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TicketsController;
use App\Http\Middleware\checkLogin;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/events',[loginController::class, "index"])->name('events');
Route::get('/', [LoginController::class, "index"]);
Route::post('/', [LoginController::class, "login"])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// middleware list event
Route::get('/events', [eventController::class, 'index'])->middleware('checkLogin')->name('events');

// create event
Route::get('/events/create', [eventController::class, 'create'])->middleware('checkLogin')->name('events.create');
Route::post('/events/create', [eventController::class, 'create_event'])->middleware('checkLogin')->name('event.create_event');

//edit event
Route::get('/events/{id}/edit', [eventController::class, 'view_edit'])->middleware('checkLogin')->name('events.edit');

//update event
Route::put('/events/{id}', [eventController::class, 'update'])->middleware('checkLogin')->name('event.update');

//show detail event
Route::get('/events/{id}', [eventController::class, 'show_detail'])->middleware('checkLogin')->name('event.detail');


// ticket
Route::get('/tickets/{id}/create', [TicketsController::class, 'create'])->middleware('checkLogin')->name('tickets.create');
Route::post('/tickets/{id}', [TicketsController::class, 'store'])->middleware('checkLogin')->name('tickets.store');

//sessions
Route::get('/sessions/{id}/create', [SessionsController::class, 'control_create'])->middleware('checkLogin')->name('sessions.create');
Route::post('/sessions/{id}', [SessionsController::class, 'create_sesions'])->middleware('checkLogin')->name('sessions.creates');


//rooms
Route::get('/rooms/{id}/create', [RoomsController::class, 'controler_rooms'])->middleware('checkLogin')->name('rooms.create');
Route::post('/rooms/{id}', [RoomsController::class, 'create_rooms']) -> middleware('checkLogin')->name('rooms.creates');


//channels
Route::get('/channels/{id}/create', [ChannelsController::class, "view_channels"])->middleware('checkLogin')->name('channels.create');
Route::post('/channels/{id}', [ChannelsController::class, "create_channels"])->middleware('checkLogin')->name('channels.creates');
