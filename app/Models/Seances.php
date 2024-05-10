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
        'heur_debut',
        'heur_fin',
        'salle',
        'nom',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    public function prof()
    {
        return $this->belongsTo(Employee::class, 'prof_id');
    }
}
