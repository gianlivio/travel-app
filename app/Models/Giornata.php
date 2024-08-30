<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giornata extends Model
{
    use HasFactory;

    protected $table = 'giornate';

    protected $fillable = ['viaggio_id', 'data'];

    public function viaggio()
    {
        return $this->belongsTo(Viaggio::class);
    }

    public function tappe()
    {
        return $this->hasMany(Tappa::class);
    }
}