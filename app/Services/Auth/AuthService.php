<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Mail\ForgetPasswordMail;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    static function register($req)
    {
        try {
            self::setRoles();

            DB::beginTransaction();

            $employee = Employee::create([
                'first_name' => Str::title($req->first_name),
                'last_name' => Str::title($req->last_name),
                'matricule' => $req->matricule,
                'email' => Str::lower($req->email),
                'sexe' => Str::lower($req->sexe),
                'dossier' => $req->dossier,
            ]);

            $user = $employee->user()->create([
                'name' => $req->first_name . ' ' . $req->last_name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
            ]);

            $user->assignRole($req->role);

            DB::commit();

            return response()->json([
                'message' => 'User created successfully',
                'user' => $employee
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    static function login($req)
    {
        try {

            $req->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::with('employee')->where('email', $req->email)->first();

            if (!$user || !Hash::check($req->password, $user->password)) {
                return response()->json([
                    'message' => 'Adresse e-mail ou mot de passe invalide. Veuillez vérifier vos identifiants et essayer à nouveau.'
                ], 401);
            }

            $token = $user->createToken('Personal Access Token')->accessToken;
            $user->getRoleNames();

            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Nous rencontrons actuellement des problèmes techniques. Réessayez plus tard ou contactez notre support si le problème persiste. Merci de votre patience.'
            ], 500);
        }
    }


    static function forgetPassword($req)
    {
        try {
            $user = User::where('email', request()->email)->first();
            if ($user) {

                $randomPassword = Str::random(12);
                $user->update(['password' => bcrypt($randomPassword)]);

                Mail::to($user->email)->send(new ForgetPasswordMail($user, $randomPassword));

                Log::info('Forget password email sent to ' . $user->email . ' at ' . now());

                return response()->json(['message' => true], 200);
            } else {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error ' . $th->getMessage()], 500);
        }
    }

    static function logout()
    {
        try {
            $user = auth('api')->user();
            foreach ($user->tokens as $token) {
                $token->revoke();
            }
            return response()->json(['message' => 'User logged out successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error ' . $th->getMessage()], 500);
        }
    }


    static function setRoles()
    {
        Role::firstOrCreate(['name' => "Professeur"]);
        Role::firstOrCreate(['name' => "Administration"]);
        Role::firstOrCreate(['name' => "Etudiant"]);
        
        
    }
}
