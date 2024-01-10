<?php

namespace App\Http\Controllers;

use App\Models\events;
use Illuminate\Http\Request;

class EventAPIController extends Controller
{
    public function index(){
        $events = events::all();
        return response()->json($events);
    }

    public function show($id){
        $event = events::find($id);
        return response()->json($event, 200);
    }
}
