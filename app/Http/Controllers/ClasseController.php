<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Services\Emp\ClasseService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClasseController extends Controller
{
    //

    public function get()
    {
        return ClasseService::get();
    }
    public function getById($id)
    {
        return ClasseService::getById($id);
    }

    public function insert(Request $request)
    {
        return ClasseService::insert($request);
    }

    public function update(Request $request, $id)
    {
        return ClasseService::update($request, $id);
    }

    public function delete($id)
    {
        return ClasseService::delete($id);
    }

    public function AffectStudentToClasse($id,Request $request)
    {
        return ClasseService::AffectStudentToClasse($id,$request);
    }

    public function GetClasseByProfId()
    {
        return ClasseService::GetClasseByProfId();
    }
    public function GetAllClasses()
    {
        return ClasseService::GetAllClasses();
    }


    
}
