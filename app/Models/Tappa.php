<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tappa extends Model
{   
    use HasFactory;

    protected $table = 'tappe';
    
    protected $fillable = ['giornata_id', 'titolo', 'descrizione', 'immagine', 'cibo', 'curiosita'];

    public function giornata()
    {
        return $this->belongsTo(Giornata::class);
    }
}