<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    protected $table = 'classe';
    protected $fillable = [
        'id',
        'prof_id',
        'nom',
    ];
    public function prof()
    {
        return $this->belongsTo(Employee::class, 'prof_id', 'id');
    }
}
