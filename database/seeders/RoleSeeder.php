<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => "Responsable d'avant projet"]);
        Role::firstOrCreate(['name' => "Business development manager"]);
        Role::firstOrCreate(['name' => "Chef de projet"]);
        Role::firstOrCreate(['name' => "Responsable d'achats"]);
        Role::firstOrCreate(['name' => "Responsable ressources humaines"]);
        Role::firstOrCreate(['name' => "Directeur activite"]);
        Role::firstOrCreate(['name' => "Responsable logistique"]);
        Role::firstOrCreate(['name' => "Directeur general"]);
        Role::firstOrCreate(['name' => "Magasinier"]);
    }
}
