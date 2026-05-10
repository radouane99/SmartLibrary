<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;
    protected $fillable = ['codeTh', 'intitule'];
    
    // protected $table="themes";
    // protected $primaryKey="codeTh";
    // protected $keyType="string";
    public function livres() 
    { 
        return $this->hasMany(Livre::class); 
    }

}
