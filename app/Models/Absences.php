<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absences extends Model
{
    use HasFactory;
    protected $table = 'absences';
    protected $fillable = [
        'id',
        'seance_id',
        'classe_id',
        'student_id',
        'motif',
        'attachement',
        'date',
    ];
    public function student()
    {
        return $this->belongsTo(Employee::class, 'student_id', 'id');
    }
    public function seance()
    {
        return $this->belongsTo(Seances::class, 'seance_id', 'id');
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id', 'id');
    }

}
