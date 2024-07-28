<?php
namespace App\Services\Emp;

use App\Models\Classe;
use App\Models\Employee;
use App\Models\Seances;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SeanceService
{
    static function get(){
            $user = auth('api')->user();
            $role = auth('api')->user()->roles[0]->name;
            Log::info($role);
            switch ($role) {
                case 'Professeur':
                    $seances = Seances::where('prof_id', $user->employee_id)->with('classe', 'prof')->get();
                    break;
                case 'Administration':
                    $seances = Seances::with('classe', 'prof')->get();
                    break;
                case 'Etudiant':
                    $student = Employee::find($user->employee_id);
                    Log::info($student);
                    $seances = Seances::with('classe', 'prof')
                                    ->where('classe_id', $student->classe_id)
                                       ->get()
                                       ->sortBy('date');
                    Log::info($seances);
                    break;
                default:
                    $seances = Seances::with('classe', 'prof')->get();
                    break;
            }  

        return response()->json([
            'seances' => $seances
        ], 200);
    }

    static function insert($request){
        try {
            $seance = Seances::create([
                'nom' => $request->input('nom'),
                'prof_id' => $request->input('prof_id'),
                'classe_id' => $request->input('classe_id'),
                'date' => $request->input('date'),
                'heur_debut' => $request->input('heur_debut'),
                'heur_fin' => $request->input('heur_fin'),
                'salle' => $request->input('salle')
            ]);
            $seance->refresh();
            return response()->json([
                'seance' => $seance
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }

    static function getSeanceById($id){
        $seance = Seances::with('classe', 'prof')->find($id);
    
        if (!$seance) {
            return response()->json(['message' => 'Seance not found'], 404);
        }
    
        $participatingStudents = Employee::where('classe_id', $seance->classe_id)
            ->whereDoesntHave('absences', function ($query) use ($id) {
                $query->where('seance_id', $id);
            })->get()->each(function ($student) {
                $student->absent = false;
            });
            Log::info($participatingStudents);

        $absentStudents = Employee::where('classe_id', $seance->classe_id)
            ->whereHas('absences', function ($query) use ($id) {
                $query->where('seance_id', $id);
            })->get()->each(function ($student) {
                $student->absent = true;
            });
            Log::info($absentStudents);

        $students = $participatingStudents->concat($absentStudents);
    
        return response()->json([
            'seance' => $seance,
            'students' => $students,
            
        ], 200);
    }

    static function getTodaysSeance(){
        $user = auth('api')->user();
        $role = auth('api')->user()->roles[0]->name;
        Log::info($role);
        Log::info($user);
        $today = date('Y-m-d'); // get today's date
        switch ($role) {
            case 'Professeur':
                $seances = Seances::where('prof_id', $user->employee_id)->with('classe', 'prof')->whereDate('date', $today)->get();
                break;
            case 'Administration':
                $seances = Seances::with('classe', 'prof')->whereDate('date', $today)->get();
            case 'Etudiant':
                $student = Employee::find($user->employee_id);
                Log::info($student);
                $seances = Seances::with('classe', 'prof')
                                ->where('classe_id', $student->classe_id)
                                   ->whereDate('date', $today)
                                   ->get()
                                   ->sortBy('date');
                Log::info($seances);
                
                break;
            default:
                $seances = Seances::with('classe', 'prof')->get();
                break;
        }
    
    return response()->json([
        'seances' => $seances
    ], 200);
}
    
    
}