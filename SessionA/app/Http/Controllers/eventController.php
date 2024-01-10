<?php

namespace App\Http\Controllers;

use App\Models\Channels;
use App\Models\event_Tickets;
use App\Models\events;
use App\Models\Registrations;
use App\Models\Rooms;
use App\Models\Sessions;
use Illuminate\Http\Request;

class eventController extends Controller
{
    public function index() {
        $events = events::where('organizer_id', session()->get('user')->id)->get();
        $eventTickets = event_Tickets::whereIn('event_id', $events->pluck('id'))->get();
        $registrations = Registrations::whereIn('ticket_id', $eventTickets->pluck('id'))->get();
        // return view('events.index',['events' => $events]);
        return view('events.index', compact("events", "registrations", "eventTickets"));
    }
    // vào view create event
    public function create() {
        return view("events.create");
    }
    // add event
    public function create_event(Request $request){
        $validatedData = $request->validate([
            'name' => "required|string",
            'slug' => "required|string|unique:events",
            'date' => 'required|date'
        ],[
            'slug.unique' => "slug đã tồn tại"
        ]);
        $event = new events;
        $event->name = $validatedData['name'];
        $event->slug = $validatedData['slug'];
        $event->date = $validatedData['date'];
        $event->organizer_id = session()->get('user')->id;
        $event->save();
        return redirect()->route('events.create')->with('success', "thành công");
    }

    // edit
    public function view_edit($id){
       $events = events::find($id);
       return view('events.edit', compact('events'));
    }


    public function update(Request $request, $id){
        $validatedData =$request->validate([
            'name' => 'require|string',     
            'slug' => 'require|string',
            'date' => 'require|string'
        ]);
        $event = events::findOrFail($id);
        $event -> name = $validatedData['name'];
        $event -> slug = $validatedData['slug'];
        $event -> date = $validatedData['date'];
        $event -> organizer_id = session()->get('user')->id;
        $event->save();
        return redirect()->route('events.edit', ['id' => $event->id])->with('success', 'update thành công');
    }
    // show detail
    public function show_detail($id) {
        $events = events::find($id);
        $tickets = event_Tickets::where("event_id", $events->id)->get();
        $channels = Channels::where('event_id', $events->id)->get();
        $rooms = Rooms::whereIn('channel_id', $channels->pluck('id'))->get();
        $sessions = Sessions::whereIn('room_id', $rooms->pluck('id'))->get();
        $sumSessions = $sessions->count();
        return view('events.detail', compact(['events', 'channels', 'rooms', 'sessions', 'tickets']));
    }
}
