<?php

namespace App\Http\Controllers;

use App\Services\Emp\AbsencesService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AbsencesController extends Controller
{
    //

    public function get()
    {
        return AbsencesService::get();
    }

    public function insert(Request $request)
    {
        return AbsencesService::insert($request);
    }

    public function MotifAbsences($id,Request $request)
    {
        return AbsencesService::MotifAbsences($id,$request);
    }
}
