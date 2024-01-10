<?php

namespace App\Http\Controllers;

use App\Models\Attendees;
use Illuminate\Http\Request;

class RegistrationAPIController extends Controller
{
    public function registration() {
        $attendees = Attendees::all();
    }
}
