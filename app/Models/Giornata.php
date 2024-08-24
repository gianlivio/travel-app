<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giornata extends Model
{   
    use HasFactory;

    protected $table = 'giornate';
     // Definisci i campi che possono essere riempiti in massa
     protected $fillable = ['viaggio_id', 'data'];

     // Definisci la relazione con Viaggio (Una Giornata appartiene a un Viaggio)
     public function viaggio()
     {
         return $this->belongsTo(Viaggio::class);
     }
 
     // Definisci la relazione con Tappa (Una Giornata ha molte Tappe)
     public function tappe()
     {
         return $this->hasMany(Tappa::class);
     }
}
