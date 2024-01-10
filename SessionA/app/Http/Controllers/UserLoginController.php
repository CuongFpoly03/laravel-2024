<?php

namespace App\Http\Controllers;

use App\Models\Attendees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'lastname' => 'required',
            'registration_code' => "required"
        ]);
        $check = Attendees::all()->where('lastname', $request->lastname)
            ->where('registration_code', $request->registration_code)->first();

        if (!$check) {
            return response()->json(['message' => 'Error'], 401);
        }
        $res = [
            'id' => $check->id,
            "firstname" => $check->firstname,
            "lastname" => $check->lastname,
            "username" => $check->username,
            "email" => $check->email,
            "token" => md5($check->username)
        ];
        $check->login_token = $res['token'];
        $check->save();
        return response()->json($res, 200);
    }
    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'token' => $user->getRememberToken()
            ]);
        } else {
            return response()->json(['message' => 'Người dùng chưa đăng nhập'], 401);
        }
    }
}
