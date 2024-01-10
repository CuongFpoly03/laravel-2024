<?php

namespace App\Http\Controllers;

use App\Models\Channels;
use App\Models\events;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    public function view_channels($id){
        $event = events::find($id);
        return view('channels.create', compact('event'));
    }

    public function create_channels(Request $request, $id){
        $validateData = $request->validate([
            'name' => 'required|string'
        ]);
        $channel = new Channels;
        $channel->event_id = $id;
        $channel->name= $validateData['name'];
        $channel->save();
        return redirect()->route('events.show', ['id' => $id])->with("success", 'tạo channel thành công');
    }
}
