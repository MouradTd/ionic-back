<?php

namespace Database\Seeders;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;
use Log;
use DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $employee = Employee::create([
                'first_name' => "BILLAL",
                'last_name' => "EL MAALMI",
                'email' => "b.elmaalmi@neweracom.ma",
                'birthdate' => Carbon::parse("1999-12-12")->format('Y-m-d'),
                'matricule' => uniqid('NEC-'),
                'sexe' => "M",
                "dossier" => "dossierbillal",
                "mode_paiement" => "Virement bancaire",
            ]);
            $employee1 = Employee::create([
                'first_name' => "BILLAL",
                'last_name' => "EL MAALMI",
                'email' => "m.m@neweracom.ma",
                'birthdate' => Carbon::parse("1999-12-12")->format('Y-m-d'),
                'matricule' => uniqid('NEC-'),
                'sexe' => "M",
                "dossier" => "dossierbillal",
                "mode_paiement" => "Virement bancaire",
            ]);

            $user = User::create([
                'email' => "b.elmaalmi@neweracom.ma",
                'password' => bcrypt("123456789"),
                'profile_picture' => 'profile_picture.png',
                'employee_id' => $employee->id,
            ]);

            $user1 = User::create([
                'email' => "dg@neweracom.ma",
                'password' => bcrypt("123456789"),
                'profile_picture' => 'profile_picture.png',
                'employee_id' => $employee1->id,
            ]);
            Log::info(bcrypt("123456789"));

            $user->assignRole(Role::where('name', "Responsable logistique")->first()->id);
            $user1->assignRole(Role::where('name', "Directeur general")->first()->id);
            $employee->update(['user_id' => $user->id]);
            $employee1->update(['user_id' => $user1->id]);
            DB::commit();


        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
