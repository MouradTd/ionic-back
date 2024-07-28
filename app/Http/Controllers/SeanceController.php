<?php

namespace App\Http\Controllers;

use App\Services\Emp\SeanceService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SeanceController extends Controller
{
    //
    public function get()
    {
        return SeanceService::get();
    }

    public function insert(Request $request)
    {
        return SeanceService::insert($request);
    }

    public function getSeanceById($id)
    {
        return SeanceService::getSeanceById($id);
    }

    public function getTodaysSeance()
    {
        return SeanceService::getTodaysSeance();
    }
}
