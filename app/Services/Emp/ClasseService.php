<?php

namespace App\Services\Emp;

use App\Models\Classe;
use App\Models\Employee;
use App\Models\Seances;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ClasseService
{

    static function get()
    {
        $classes = Classe::all();

        return response()->json([
            'classes' => $classes
        ], 200);
    }
    static function getById($id)
    {
        $classe = Classe::with('prof','students','sceance.prof')->find($id);

        if (!$classe) {
            return response()->json([
                'message' => 'Classe not found'
            ], 404);
        }
        return response()->json([
            'classe' => $classe
        ], 200);
    }

    static function insert($request)
    {
        try {
            $classe = Classe::create([
                'nom' => $request->input('nom'),
                'prof_id' => $request->input('prof_id'),
                // 'student_id' => $request->input('student_id'),

            ]);
            $classe->refresh();
            return response()->json([
                'classe' => $classe
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }

    static function update($request, $id)
    {
        $classe = Classe::find($id);

        if (!$classe) {
            return response()->json([
                'message' => 'Classe not found'
            ], 404);
        }
        $classe->update([
            'nom' => $request->input('nom'),
            'prof_id' => $request->input('prof_id'),
        ]);
        $classe->refresh();
        return response()->json([
            'classe' => $classe
        ], 200);
    }

    static function delete($id)
    {
        $classe = Classe::find($id);

        if (!$classe) {
            return response()->json([
                'message' => 'Classe not found'
            ], 404);
        }
        $classe->delete();
        return response()->json([
            'message' => 'Classe deleted'
        ], 200);
    }

    static function AffectStudentToClasse($id, $request)
    {
        try {
            $classe = Classe::find($id);
            if (!$classe) {
                return response()->json([
                    'message' => 'Classe not found'
                ], 404);
            }
            $student = Employee::find($request->input('student_id'));
            if (!$student) {
                return response()->json([
                    'message' => 'Student not found'
                ], 404);
            }
            $student->update([
                'classe_id' => $classe->id
            ]);
            return response()->json([
                'student' => $student
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }

    static function GetClasseByProfId()
    {
        try {

            $professor = auth('api')->user();
            $role = auth('api')->user()->roles[0]->name;
            Log::info($role);
            Log::info($professor);
            $today = date('Y-m-d'); // get today's date
            switch ($role) {
                case 'Professeur':
                    $seances = Seances::where('prof_id', $professor->employee_id)
                        ->whereDate('date', $today)
                        ->get()
                        ->sortBy('date');
                    $classes = $seances->map(function ($seance) {
                        $classe = Classe::where('id', $seance->classe_id)->first();
                        return [
                            'seance' => $seance,
                            'classe' => $classe,
                        ];
                    });
                    break;
                case 'Administration':
                    $seances = Seances::whereDate('date', $today)
                        ->get()
                        ->sortBy('date');
                    $classes = $seances->map(function ($seance) {
                        $classe = Classe::where('id', $seance->classe_id)->first();
                        return [
                            'seance' => $seance,
                            'classe' => $classe,
                        ];
                    });
                    break;
                default:
                    $seances = Seances::all()
                        ->whereDate('date', $today)
                        ->get()
                        ->sortBy('date');
                    $classes = $seances->map(function ($seance) {
                        $classe = Classe::where('id', $seance->classe_id)->first();
                        return [
                            'seance' => $seance,
                            'classe' => $classe,
                        ];
                    });

                    break;
            }
            // $seances = Seances::where('prof_id', $professor->employee_id)
            //                    ->whereDate('date', $today)
            //                    ->get()
            //                    ->sortBy('date');
            // $classes = $seances->map(function ($seance) {
            //     $classe = Classe::where('id', $seance->classe_id)->first();
            //     return [
            //         'seance' => $seance,
            //         'classe' => $classe,
            //     ];
            // });            

            return response()->json([
                'classe' => $classes,
                'kpis' => [
                    'total_classes' => $classes->count(),
                    'total_seances' => $seances->count()
                ]
                // 'students' => $students,
                // 'seances' => $seances,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }


    static function GetAllClasses()
    {
        try {

            $professor = auth('api')->user();
            $role = auth('api')->user()->roles[0]->name;
            Log::info($role);
            Log::info($professor);
            Log::info($professor->id);
            switch ($role) {
                case 'Professeur':
                    $classes = Classe::where('prof_id', $professor->employee_id)->get();
                    break;
                case 'Administration':
                    $classes = Classe::all();
                    break;
                default:
                    $classes = Classe::all();
                    break;
            }            

            return response()->json([
                'classe' => $classes,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
