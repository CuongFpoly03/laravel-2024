<?php

namespace App\Http\Controllers;

use App\Models\Channels;
use App\Models\events;
use App\Models\Rooms;
use App\Models\Sessions;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function control_create($id) {
        $event = events::find($id);
        $channels = Channels::where('event_id', $event->id)->get();
        $rooms = Rooms::whereIn('channel_id', $channels->pluck('id'))->get();
        return view('sessions.create', compact('event', 'rooms'));

    }
    public function create_sesions(Request $request, $id){
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string',
            "speaker" => "required|string",
            "start"=> "required",
            "end"=> "required"
        ]);
        $session = new Sessions;
        $session->room_id = $request->room;
        $session->title = $request->title;
        $session->speaker = $request->speaker;
        $session->description = $request->description;
        $session->start = $request->start;
        $session->end = $request->end;
        $session->save();
        return redirect()->route('events.show',['id' => $id])->with('success', "tạo sessions thành công");  
    }
}
