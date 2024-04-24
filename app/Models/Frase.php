<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frase extends Model
{
    use HasFactory;

    protected $fillable = [
        'frase',
        'autore'
    ];

    protected $casts = [
        'data' => 'datetime',
        'aggiunto_da' => 'string', // aggiunto_da is a string
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'categoria' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
