<?php

namespace Database\Seeders;

use App\Models\Caisse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaisseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Caisse::create([
            'nom' => 'Caisse principale',
            'solde' => 0,
        ]);
    }
}
