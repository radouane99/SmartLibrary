<?php

namespace App\Models;
use Thiagoprz\CompositeKey\HasCompositeKey;
use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    protected $guarded = [];

    public function livre()
    { 
        return $this->belongsTo(Livre::class); 
    }
    public function user()
    { 
        return $this->belongsTo(User::class); 
    }
}
