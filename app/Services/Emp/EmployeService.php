<?php

namespace App\Services\Emp;

use ZipArchive;
use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Support\Str;
use App\Imports\EmployeImport;
use App\Models\Classe;
use App\Models\Seances;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;


class EmployeService
{

    static function insert($request)
    {
        try {
            /*  $cin = $request->file('cin_copie');
            $cin_name = $cin->getClientOriginalName();

            $rib = $request->file('rib_copie');
            $rib_name = $cin->getClientOriginalName(); */


            $folderName = $request->input('first_name') . "_" . $request->input('last_name');
            $uploadPath = public_path("uploads/employe/{$folderName}");

            // Check if the folder exists, if not, create it
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move the file to the folder
            /* $cin->move($uploadPath, $cin_name);
            $rib->move($uploadPath, $rib_name); */

            $currentDate = Carbon::parse($request->input('date_embauche'));

            // Add the specified number of months to the current date
            $futureDate = $currentDate->addMonths((int) $request->input('Augmentation') + 1);

            $email = Str::lower($request->input('first_name')) . Str::lower($request->input('last_name')) . '@neweracom.com';

            // Format the future date as needed
            $formattedDate = $futureDate->toDateString();
            $lastMatricule = Employee::orderBy('id', 'desc')->first()->matricule;
            $employee = Employee::create([
                'first_name' => Str::title($request->input('first_name')),
                'last_name' => Str::title($request->input('last_name')),
                'phone_no' => $request->input('phone_no'),
                'matricule' => (int) $lastMatricule + 1,
                'salary' => $request->input('salary'),
                'poste' => $request->input('poste'),
                'departement' => $request->input('departement'),
                'cin' => $request->input('cin'),
                'rib' => $request->input('rib'),
                'sexe' => $request->input('sexe'),
                'type_contrat' => $request->input('type_contrat'),
                'email' => $email,
                'birthdate' => Carbon::parse($request->input('birthdate')),
                'ville' => $request->input('city'),
                'adresse' => $request->input('adresse'),
                'date_embauche' => Carbon::parse($request->input('date_embauche')),
                'status' => 1,
                'copie_cin' => 'cin',
                'copie_rip' => 'rib',
                "dossier" => $folderName,
                "societe" => 'NewEraCom',
                "bank_name" => $request->input('bank_name'),
                "salaire_jrs" => $request->input('salary') / 26,
                "conge_mois" => $request->input('conge_mois'),
                'duree_contrat' => $request->input('duree'),
                'mode_paiement' => $request->input('mode_paiement'),
                'Augmentation' => $request->input('Augmentation'),
                'Agt_date' => $formattedDate,
                'solde_conge' => 0,
                'fin_contrat' => $request->input('fin_contrat') ? Carbon::parse($request->input('fin_contrat')) : null,
            ]);




            $employee->refresh();

            $employee->load('projects', 'projects.preProject', 'documents', 'conges', 'historiquesalaire', 'historiquePaye', 'pointages');


            return response()->json([
                'employee' => $employee,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 409);
        }
    }


    static function getById($id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                return response()->json([
                    'message' => 'Employee not found'
                ], 404);
            }
            return response()->json([
                'employee' => $employee
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 409);
        }
    }
    static function get()
    {
        try {
            $employees = Employee::all();
            return response()->json([
                'employees' => $employees
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 409);
        }
    }




    static function delete($id)
    {
        try {
            // Assuming you have an Employee model
            $employee = Employee::find($id);

            if (!$employee) {
                return response()->json([
                    'message' => 'Employee not found'
                ], 404);
            }

            $employee->delete();
            return response()->json([
                'employee' => $employee->id,
                'message' => 'Employee deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 409);
        }
    }


    static function upload($request)
    {
        try {
            $file = $request->file('file');
            if ($file) {
                $employeImport = new EmployeImport($request->created_by);
                Excel::import($employeImport, $file);
            }
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 409);
        }
    }







    static function update($id, $request)
    {
        try {
            Log::info($request);
            $employee = Employee::findOrFail($id);
            if (!$employee) {
                return response()->json([
                    'message' => 'Employee not found'
                ], 404);
            }

            // Update employee data
            $employee->update([
                'first_name' => $request->input('first_name') ? Str::title($request->input('first_name')) : $employee->first_name,
                'last_name' => $request->input('last_name') ? Str::title($request->input('last_name')) : $employee->last_name,
                'poste' => $request->input('poste') ? Str::title($request->input('poste')) : $employee->poste,
                'departement' => $request->input('departement') ? Str::title($request->input('departement')) : $employee->departement,
                'sexe' => $request->input('sexe') ? $request->input('sexe') : $employee->sexe,
                'ville' => $request->input('ville') ? Str::title($request->input('ville')) : $employee->ville,
                'adresse' => $request->input('adresse') ? Str::title($request->input('adresse')) : $employee->adresse,
                'phone_no' => $request->input('phone_no') ? $request->input('phone_no') : $employee->phone_no,
                'flotte' => $request->input('flotte') ? $request->input('flotte') : $employee->phone_no,
                'email' => $request->input('email') ? Str::lower($request->input('email')) : $employee->email,
                'cin' => $request->input('cin') ? Str::upper($request->input('cin')) : $employee->cin,
                'birthdate' => Carbon::parse($request->input('birthdate')) ? Carbon::parse($request->input('birthdate')) : $employee->birthdate,
                'situation_familiale' => $request->input('situation_familiale') ? $request->input('situation_familiale') : $employee->situation_familiale,
                'num_personne_charge' => $request->input('num_personne_charge') ? $request->input('num_personne_charge') : $employee->num_personne_charge,
            ]);


            $employee->load('projects', 'documents', 'conges', 'historiquesalaire', 'historiquePaye', 'pointages');
            $employee->refresh();

            return response()->json([
                'employee' => $employee,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 409);
        }
    }









    static function DownloadFiles($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            if (!$employee) {
                return response()->json([
                    'message' => 'Employee not found'
                ], 404);
            }

            $zip = new ZipArchive();
            $zipFileName = $employee->dossier . '.zip';
            $zipFilePath = public_path("uploads/{$zipFileName}");

            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $folderPath = public_path("uploads/{$employee->dossier}");

                chdir($folderPath);

                if (is_dir($folderPath)) {
                    $globStatus = $zip->addGlob('*');
                }

                $zip->close();

                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            } else {
                return response()->json([
                    'message' => 'Failed to create the zip file'
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 409);
        }
    }

    public static function downloadAllFiles()
    {
        try {
            // Create a temp directory if it doesn't exist
            $tempDir = public_path('uploads/temp');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0777, true);
            }
            chmod($tempDir, 0777);

            $employees = Employee::all();
            foreach ($employees as $employee) {
                $zipFileName = "{$employee->dossier}.zip";
                $zipFilePath = "{$tempDir}/{$zipFileName}";
                // Create a zip file for each employee
                $zip = new ZipArchive;
                if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                    $folderPath = public_path("uploads/{$employee->dossier}");

                    $files = File::allFiles($folderPath);
                    foreach ($files as $file) {
                        $zip->addFile($file->getPathname(), $file->getRelativePathname());
                    }

                    $zip->close();
                } else {
                    return response()->json([
                        'message' => 'Failed to open final zip archive'
                    ], 500);
                }
                // Wait for 0.5 seconds before creating the next zip file
                usleep(500000);
            }

            // Create a final zip file containing all individual zip files
            $finalZipFileName = 'all_employees.zip';
            $finalZipFilePath = "{$tempDir}/{$finalZipFileName}";

            $finalZip = new ZipArchive;
            if ($finalZip->open($finalZipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $finalZipFiles = File::allFiles($tempDir);
                foreach ($finalZipFiles as $finalZipFile) {

                    if ($finalZipFile->getRelativePathname() != $finalZipFileName) {
                        $finalZip->addFile($finalZipFile->getPathname(), $finalZipFile->getRelativePathname());
                    }
                }

                $finalZip->close();
            } else {
                return response()->json([
                    'message' => 'Failed to create final zip file'
                ], 500);
            }

            // Download the final zip file
            return response()->download($finalZipFilePath)->deleteFileAfterSend(true);
            dispatch(function () use ($tempDir) {
                File::deleteDirectory($tempDir);
            })->delay(now()->addMinutes(1));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    static function statsProfesser()
    {
        $professor = auth('api')->user(); // get the logged in professor
        Log::info($professor);

        $classes = Classe::where('prof_id', $professor->employee_id)->get(); // get the classes of the professor
        Log::info($classes->count());


        $numStudents = 0;
        foreach ($classes as $class) {
            $numStudents += Employee::where('classe_id', $class->id)->count(); // count the number of students in each class
        }
        return [
            'numClasses' => $classes->count(),
            'numStudents' => $numStudents
        ];
    }


    static function getStudentsByClasse($id)
    {
        try {
            $currentHour = Carbon::now();
            $classe = Classe::find($id);
            if (!$classe) {
                return response()->json([
                    'message' => 'Classe not found'
                ], 404);
            }
            $students = Employee::where('classe_id', $id)->get();
            $seance = Seances::where('classe_id', $id)
                             ->where(function($query) use ($currentHour) {
                                 $query->where('heur_debut', '<=', $currentHour->format('H:i:s'))
                                       ->where('heur_fin', '>=', $currentHour->format('H:i:s'));
                             })
                             ->first();
            
            return response()->json([
                'students' => $students,
                'classe' => $classe,
                'seance' => $seance
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 409);
        }
    }

    static function getStudents(){
        $students = Employee::where('type', 'etudiant')
        ->with('classes')
        ->get();
        return response()->json([
            'students' => $students
        ], 200);
    }
    
    static function addStudent($request){
        try {
            $student = Employee::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_no' => $request->input('phone_no'),
                'sexe' => $request->input('sexe'),
                'birthdate' =>Carbon::parse($request->input('birthdate')),
                'classe_id' => $request->input('classe_id'),
                'type' => 'etudiant',
                'classe_id'=>$request->input('classe_id'),
            
            ]);
            $student->refresh();
            $student->load('classes');
            return response()->json([
                'message' => 'Students added to the class successfully',
                "student" => $student
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 409);
        }
    }
    static function getStudentById($id){
        $student = Employee::find($id);

        if ($student) {
            $student->load('classes','absences','absences.seance');
        } else {
            return response()->json([
                'message' => "Student not found"
            ], 200);
        }
        return response()->json([
            'student' => $student
        ], 200);
        
    }

    static function getProfs(){
        $profs = Employee::where('type', 'prof')
        ->get();
        return response()->json([
            'profs' => $profs
        ], 200);
    }

}
