<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaggio extends Model
{
    use HasFactory;

    protected $table = 'viaggi'; 

    protected $fillable = ['titolo', 'meta', 'durata', 'periodo', 'dettagli', 'immagine', 'user_id'];

    public function giornate()
    {
        return $this->hasMany(Giornata::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}