<?php

namespace App\Http\Controllers;
use DateTime;
use App\Models\Channels;
use App\Models\event_Tickets;
use App\Models\events;
use App\Models\Registrations;
use App\Models\Rooms;
use App\Models\sessionRegistrations;
use App\Models\Sessions;
use Illuminate\Http\Request;

class TicketsAPIController extends Controller
{
    function show($id) {
        $tickets = event_Tickets::where('event_id', $id) -> get();
        return response()->json($tickets, 200);
    }

    function getWorkshops($id) {
        $events = events::find($id);
        $channels = Channels::whereIn('event_id', $events->id)->get();
        $rooms = Rooms::whereIn('channel_id', $channels->puck('id'))->get();
        $sessions = Sessions::whereIn('room_id', $rooms->pluck('id'))->get();

        return response()->json($sessions, 200);
    }

    function buyTicket(Request $request){
        $registrations = new Registrations;
        $registrations -> attendee_id = $request->attendee_id;
        $registrations -> ticket_id = $request->ticket_id;
        $registrations -> registration_time = new DateTime();
        $registrations->save();

        return response()->json($registrations, 200);
    }

    function buyOtherTicket(Request $request){
        $registrations = new sessionRegistrations;
        $registrations -> registration_id = $request->registration_id;
        $registrations-> session_id = $request->session_id;
        $registrations->save();
    }

    
}
