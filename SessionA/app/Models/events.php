<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    use HasFactory;
    public $timestamps= false;
    public function Channels(){
        return $this->hasMany(Channels::class);
    }
    
}
