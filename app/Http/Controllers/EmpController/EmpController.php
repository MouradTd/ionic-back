<?php

namespace App\Http\Controllers\EmpController;

use Illuminate\Http\Request;
use App\Services\Emp\EmployeService;
use Illuminate\Routing\Controller;

class EmpController extends Controller
{

    public function insert(Request $request)
    {
        return EmployeService::insert($request);
    }

    public function get()
    {
        return EmployeService::get();
    }

    public function getById($id)
    {
        return EmployeService::getById($id);
    }

    

    public function upload(Request $request)
    {
        return EmployeService::upload($request);
    }

   

    
    public function delete($id)
    {
        return EmployeService::delete($id);
    }

    public function statsProfesser()
    {
        return EmployeService::statsProfesser();
    }

    public function getStudentsByClasse($id)
    {
        return EmployeService::getStudentsByClasse($id);
    }


    
    public function update($id, Request $request)
    {
        return EmployeService::update($id, $request);
    }
    
    public function DownloadFiles($id)
    {
        return EmployeService::DownloadFiles($id);
    }
    public function downloadAllFiles()
    {
        return EmployeService::downloadAllFiles();
    }

    public function getStudents(){
        return EmployeService::getStudents();
    }

    public function addStudent(Request $request){
        return EmployeService::addStudent($request);
    }

    public function getStudentById($id){
        return EmployeService::getStudentById($id);
    }

    
}
