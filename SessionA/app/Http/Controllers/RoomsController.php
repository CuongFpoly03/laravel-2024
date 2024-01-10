<?php

namespace App\Http\Controllers;

use App\Models\Channels;
use App\Models\events;
use App\Models\Rooms;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function controler_rooms($id){
        $event = events::find($id);
        $channels = Channels::where('event_id', $id)->get();
        return view('rooms.create', compact('event', 'channels'));
    }
    public function create_rooms(Request $request, $id){
        $validateData = $request->validate([
            'name' => 'required|string',
            'capacity' => 'required'
        ]);
        $room = new Rooms;
        $room->name= $validateData['name'];
        $room->channel_id = $request->channel;
        $room->capacity = $validateData['capacity'];
        $room->save();
        return redirect()->route('events.show', $id)->with('success', "tạo phòng thành công");

    }
}
