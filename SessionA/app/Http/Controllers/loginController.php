<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Organizers; // kiểm tra người đung có tồn tại trong csdl hay k

class loginController extends Controller
{
    public function index() {
        return view('index');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' =>'required'
        ]);

       $check = Organizers::where("email", $request->email)->first();
       if($check){
        if($request->password == $check->password_hash){
            session()->put('user', $check);
            return redirect()->route('events');

        }else {
            return redirect()->back()->with('error', "sai passs");
        }
        
    }else {
        return redirect()->back()->with('error', "bạn nhập sai email");
    }
    }

    public function logout(){
        session()->forget('user');
        return redirect('/');
    }
}
