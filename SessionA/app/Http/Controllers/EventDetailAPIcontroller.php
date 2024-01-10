<?php

namespace App\Http\Controllers;

use App\Models\Attendees;
use App\Models\Channels;
use App\Models\event_Tickets;
use App\Models\events;
use App\Models\Organizers;
use App\Models\Registrations;
use App\Models\Rooms;
use App\Models\Sessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class EventDetailAPIcontroller extends Controller
{
    public function show($slug1, $slug2){
        $organizers = Organizers::where('slug', $slug1)->first();
        
        if(!$organizers){
            return response()->json(['message', '0 tim thay'], 404);
        }
        $event = events::where('organizer_id', $organizers->id)->where('slug', $slug2)->first();
        if(!$event){
            return response()->json('message', "0 tim thay");
        }
        $ticket = event_Tickets::where('event_id', $event->id)->get();
        $channel = Channels::where('event_id', $event->id)->get();
        $room = Rooms::whereIn('channel_id', $channel->pluck('id'))->get();
        $session = Sessions::whereIn('room_id',$room->puck('id'))->get();

        $res = [
            'id' => $event->id,
            'name'=>$event->name,
            'slug' => $event->slug,
            'date' => $event->date,
            'channels' => $channel->map(function($channel) use ($room, $session){
                return [
                    'id' => $channel->id,
                    'name' => $channel->name,
                    'romms' => $room->where('channel_id', $channel->id)->map(function($room) use ($session){
                        return [
                            'id' => $room->id,
                            'name'=> $room->name,
                            "sessions" => $session->where('room_id', $room->id)->map(function($session){
                                return [
                                    'id' => $session->id,
                                    'title' => $session->title,
                                    'description' => $session->description,
                                    'speaker' => $session->speaker,
                                    'start' => $session->start,
                                    'end' => $session->end,
                                    'type' => $session->type,
                                    'cost' => $session->cost ?? null
                                ];
                            })
                        ];
                    })
                ];
            }),
            "tickets" => $ticket->map(function($ticket){
                return [
                    'id' => $ticket->id,
                    'name' => $ticket->name,
                    'description'=> $ticket->description,
                    'cost'=>$ticket->cost,
                    'available'=> $ticket->available
                ];
            })
        ];
        return response() ->json($res, 200);
    }

    public function registration(Request $request){
        if(!Auth::check()){
            return response()->json(['message'=>'nguoi dung ch dang nhap'],401);
        }

        $user = Auth::user();
        $registration =  Registrations::where('attendee_id', $user->id)->first();
        if($registration){
            return response()->json(['message'=> 'nguoi dung da dang ky'], 401);
        }

        $ticket = event_Tickets::find($request->ticket_id);
        if(!$ticket){
            return response()->json(['message'=> 've khong san co', 401]);
        }
        $newRegistration = new Registrations();
        $newRegistration -> attendee_id = $user->id;
        $newRegistration -> ticket_id = $request->ticket->id;
        $newRegistration->save();

        return response()->json(['message' => 'dang ky thanh cong']);
    }
}
