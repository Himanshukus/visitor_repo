<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meetingreponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'email', 
        'meeting_id', 
        'response', 
    ];
}
