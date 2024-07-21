<?php

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EmpController\EmpController;
use App\Http\Controllers\AbsencesController;
use App\Http\Controllers\SeanceController;

Route::get('/', function (Request $request) {
    return response()->json([
        'message' => 'Hello World!'
    ], 200);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
});

Route::middleware('auth:api')->prefix('employe')->group(function () {
    Route::get('/get', [EmpController::class, 'get']);
    Route::get('/get/{id}', [EmpController::class, 'getById']);
    Route::post('/insert', [EmpController::class, 'insert']);
    Route::post('/upload', [EmpController::class, 'upload']);
    Route::delete('/delete/{id}', [EmpController::class, 'delete']);
    Route::post('/update/{id}', [EmpController::class, 'update']);
    Route::get('/DownloadFiles/{id}', [EmpController::class, 'DownloadFiles']);
    Route::get('/downloadAllFiles', [EmpController::class, 'downloadAllFiles']);
    Route::get('/statsProfesser', [EmpController::class, 'statsProfesser']);
    Route::get('/getStudentsByClasse/{id}/{sceanceId}', [EmpController::class, 'getStudentsByClasse']);
    Route::get('/getStudents', [EmpController::class, 'getStudents']);
    Route::get('/getProfs', [EmpController::class, 'getProfs']);
    Route::get('/getStudent/{id}', [EmpController::class, 'getStudentById']);
    Route::post('/addStudent', [EmpController::class, 'addStudent']);

});

Route::middleware('auth:api')->prefix('classe')->group(function () {
    Route::get('/get', [ClasseController::class, 'get']);
    Route::post('/insert', [ClasseController::class, 'insert']);
    Route::post('/update/{id}', [ClasseController::class, 'update']);
    Route::delete('/delete/{id}', [ClasseController::class, 'delete']);
    Route::post('/AffectStudentToClasse/{id}', [ClasseController::class, 'AffectStudentToClasse']);
    Route::get('/GetClasseByProfId', [ClasseController::class, 'GetClasseByProfId']);
});

Route::middleware('auth:api')->prefix('absence')->group(function () {
    Route::get('/get', [AbsencesController::class, 'get']);
    Route::post('/insert', [AbsencesController::class, 'insert']);
    Route::post('/MotifAbsences/{id}', [AbsencesController::class, 'MotifAbsences']);
    Route::get('/getLatestAbsences', [AbsencesController::class, 'getLatestAbsences']);
});


Route::middleware('auth:api')->prefix('sceance')->group(function () {
    Route::get('/get', [SeanceController::class, 'get']);
    Route::post('/insert', [SeanceController::class, 'insert']);
    Route::get('/get/{id}', [SeanceController::class, 'getSeanceById']);
});






Route::post('/update-employee', function () {
    $employees = Employee::all();

    foreach ($employees as $key => $value) {
        $value->update([
            'first_name' => Str::title($value->first_name),
            'last_name' => Str::title($value->last_name),
            'sexe' => Str::title($value->sexe),
            'poste' => Str::title($value->poste),
            'status' => $value->date_depart !== null ? 0 : 1,
            'departement' => Str::title($value->departement),
            'salary' => number_format((float) $value->salary, 2, '.', ''),
            'salary_net' => number_format((float) $value->salary_net, 2, '.', ''),
            'salary_brut' => number_format((float) $value->salary_brut, 2, '.', ''),
            'salaire_jrs' => number_format((float) $value->salaire_jrs, 2, '.', ''),
            'conge_mois' => $value->date_depart !== null ? 0 : $value->conge_mois,
            'adresse' => Str::title($value->adresse),
            'ville' => Str::title($value->ville),
        ]);
    }

    return response()->json([
        'message' => 'success'
    ], 200);
});



Route::post('/refactor-data', function () {

    $employees = Employee::all();

    foreach ($employees as $item) {
        $item->update([
            'first_name' => Str::title($item->first_name),
            'last_name' => Str::title($item->last_name),
            'sexe' => Str::title($item->sexe),
            'situation_familiale' => Str::title($item->situation_familiale),
            'ville' => Str::title($item->ville),
            'adresse' => Str::title($item->adresse),
            'poste' => Str::title($item->poste),
            'duree_contrat' => 6,
            'fin_contrat' => Carbon::parse($item->date_embauche)->addMonths(6),
            'departement' => Str::title($item->departement),
        ]);

       
    }

    return response()->json([
        'message' => 'success',
    ], 200);
});

Route::get('/test-api', function () {
    return response()->json([
        'message' => auth('api')->user(),
    ], 200);
})->middleware('auth:api');


