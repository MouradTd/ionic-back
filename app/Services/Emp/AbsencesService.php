<?php

namespace App\Services\Emp;

use App\Models\Absences;

class AbsencesService
{
    static function get(){
        $absences = Absences::all();

        return response()->json([
            'absences' => $absences
        ], 200);
    }

    static function insert($request){
        try {
            $students = $request->input('students'); 
            $date = $request->input('date');
            $seance_id = $request->input('seance_id');
            $classe_id = $request->input('classe_id');

            foreach ($students as $student_id) {
                Absences::create([
                    'date' => $date,
                    'student_id' => $student_id,
                    'seance_id' => $seance_id,
                    'classe_id' => $classe_id,
                ]);
            }
          
            return response()->json([
                'message' => 'Absences created successfully'
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }

    static function MotifAbsences($id,$request){
        $absence = Absences::find($id);

        if(!$absence){
            return response()->json([
                'message' => 'Absence not found'
            ], 404);
        }
        if ($request->hasFile('motif')) {
            $file = $request->file('motif');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/motif');
            $file->move($destinationPath, $filename);

            $absence->update([
                'motif' =>$filename,
            ]);
        }
        $absence->refresh();
        return response()->json([
            'absence' => $absence
        ], 200);
    }


}