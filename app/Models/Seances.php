<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seances extends Model
{
    use HasFactory;
    protected $table = 'seance';
    protected $fillable = [
        'id',
        'prof_id',
        'classe_id',
        'date',
        'heure_debut',
        'heure_fin',
        'salle',
    ];
}
