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

    public function tappe()
    {
        return $this->hasMany(Tappa::class);
    }

    // Definisci la relazione inversa con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Immagine di anteprima
    public function previewImage()
    {
        return $this->hasOne(Image::class)->where('is_preview', true);
    }
}