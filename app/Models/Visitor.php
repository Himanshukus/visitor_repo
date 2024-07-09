<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

   
    public function host()
    {
        return $this->hasOne(User::class, 'id', 'host_id');
    }
}
