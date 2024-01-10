<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event_Tickets extends Model
{
    public $timestamps= false;
    use HasFactory;
    protected $table = 'event_tickets';
}
