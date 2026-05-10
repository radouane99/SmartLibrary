<?php

namespace App\Models;
use Thiagoprz\CompositeKey\HasCompositeKey;
use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    //
    // protected $table="emprunts";
    // protected $primaryKey = ['codeA', 'codeL'];
    // protected $keyType="string";
    // protected $primaryKey = ['adherent_id', 'livre_id'];
    public function livre()
    { 
        return $this->belongsTo(Livre::class); 
    }
    public function user()
    { 
        return $this->belongsTo(User::class); 
    }

    // protected $table="emprunts";
    // protected $primaryKey="codeA";
    // protected $primaryKey="codeL";       IMPOSSIBLE 2 CLE PRIMAIRES
    // protected $keyType="string";
}
