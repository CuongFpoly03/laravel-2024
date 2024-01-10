<?php

namespace App\Http\Controllers;

use App\Models\event_Tickets;
use Illuminate\Http\Request;
use App\Models\EventTickets;    
use App\Models\Events;

class TicketsController extends Controller
{
    public function create($id){
        $events = Events::all()->find($id);

        return view("tickets.create", compact("events", "id"));
    }
    public function store(Request $request, $id){
        $validate = $this->validate($request, [
            "name" => "required|string",
            "cost"=> "required|numeric",
            "valid_until" => "required",
        ],[
            "name.required" => "Tên không được để trống",
            "cost.required" => "Giá không được để trống",
            "valid_until.required" => "valid_until không được để trống",
        ]);

        $ticket = new event_Tickets;
        $ticket->event_id = $id;
        $ticket->name = $validate['name'];
        $ticket->cost = $validate['cost'];
        if($request->special_validity === 'amount'){
            $ticket->special_validity = '{"type" : "amount", "amount" : "'.$request->amount.'"}';
        }else if($request->special_validity === 'date'){
            $ticket->special_validity = '{"type" : "date", "date" : "'.$request->valid_until.'"}';
        }else{
            $ticket->special_validity = null;
        }
        $ticket->save();
        return redirect()->route('tickets.create', ['id'=>$id])->with('success', "Vé được tạo thành công");
    }
}
