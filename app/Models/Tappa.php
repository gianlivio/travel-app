<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tappa extends Model
{   
    use HasFactory;

    protected $table = 'tappe';
    
    // Definisci i campi che possono essere riempiti in massa
    protected $fillable = ['giornata_id', 'titolo', 'descrizione', 'immagine', 'cibo', 'curiosita'];

    // Definisci la relazione con Giornata (Una Tappa appartiene a una Giornata)
    public function giornata()
    {
        return $this->belongsTo(Giornata::class);
    }
}
