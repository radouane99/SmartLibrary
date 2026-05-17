<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    //
    // protected $table="livres";
    // protected $primaryKey="codeL";
    // protected $keyType="string";
    // public function adherents()
    // {
    //     return $this->belongsToMany(Adherent::class);
    // }
    use HasFactory;
    protected $fillable = ["codeL", "titre", "auteur", "nbExemplaire", "theme_id", "couverture"];
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }

}
