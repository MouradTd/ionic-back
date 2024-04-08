<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'phone_no',
        'matricule',
        'email',
        'birthdate',
        'sexe',
        'cin',
        'copie_cin',
        'cnss',
        'copie_cnss',
        'rib',
        'copie_rib',
        'bank_name',
        'date_embauche',
        'date_depart',
        'departement',
        'poste',
        'type_contrat',
        'salary',
        'date_virement',
        'solde_conge',
        'status',
        'picture',
        'user_id',
        'dossier',
        'ville',
        'salaire_jrs',
        'conge_mois',
        'anciente',
        'adresse',
        'motif_depart',
        'duree_contrat',
        'fin_contrat',
        'working_hours',
        'classe_id',
        'type'
    ];


    // Employee Model
    public function user_res()
    {
        return $this->belongsTo(User::class, 'responsable_id', 'id');
    }

 
    public function classes() {
        return $this->hasMany(Classe::class, 'prof_id', 'id');
    }

    public function seances() {
        return $this->hasMany(Seances::class, 'prof_id', 'id');
    }

    public function absences() {
        return $this->hasMany(Absences::class, 'student_id', 'id');
    }
    

    

    // public function absences()
    // {
    //     return $this->hasMany(Absence::class, 'employe_id', 'id');
    // }

    public function user()
    {
        return $this->hasOne(User::class);
    }

   
}
