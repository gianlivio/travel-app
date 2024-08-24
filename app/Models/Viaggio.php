<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaggio extends Model
{
    use HasFactory;

    protected $fillable = ['titolo', 'descrizione', 'user_id'];

    public function giornate()
    {
        return $this->hasMany(Giornata::class);
    }

    // Definisci la relazione inversa con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
