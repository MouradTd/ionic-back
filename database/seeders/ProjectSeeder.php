<?php

namespace Database\Seeders;

use App\Models\PreProject;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            PreProject::create([
                "project_code" => "SIEGE",
                "maitre_ouvrage" => "Maitre d'ouvrage",
                "n_offre" => "00000",
                "objet" => "Objet",
                "date_depot" => "2020-01-01",
                "created_by" => 1,
                "type_project" => "type_project",
                "status" => "status",
                "chiffrage_status" => "chiffrage_status",
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }
}
