<?php

namespace App\Imports;

use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;

class EmployeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // $cin = $row['cin_copie']; // Assuming 'cin' is the field in the CSV file representing the CIN file name

        // // Check if the CIN file exists
        // if ($cin) {
        //     $folderName = $row['first_name'] . "_" . $row['last_name'];
        //     $uploadPath = public_path("uploads/{$folderName}");

        //     // Check if the folder exists, if not, create it
        //     if (!file_exists($uploadPath)) {
        //         mkdir($uploadPath, 0777, true);
        //     }

        //     // Copy the CIN file to the destination folder
        //     $sourcePath = public_path("uploads/{$folderName}/{$cin}");
        //     $destinationPath = "{$uploadPath}/{$cin}";

        //     copy($sourcePath, $destinationPath);
        // }

        // return new Employee([
        //     'matricule'     => $row['matricule'],
        //     'first_name'    => $row['first_name'],
        //     'last_name'     => $row['last_name'], 
        //     'cin'           => $row['cin'], 
        //     'date_embauche' => Carbon::parse($row['date_embauche'])->format('Y-m-d '), 
        //     'phone_no'      => $row['phone_no'], 
        //     'sexe'          => $row['sexe'], 
        //     'email'         => $row['email'],
        //     'status'        => $row['status'],
        //     "copie_cin" =>  "{$folderName}/{$cin}"
        // ]);
        return new Employee([
            'matricule'     => $row['matricule'],
            'first_name'    => $row['first_name'],
            'last_name'    => $row['last_name'],
            'cin'    => $row['cin'],
            'date_embauche'    => Carbon::parse($row['date_embauche'])->format('Y-m-d '),
            'phone_no'    => $row['phone_no'],
            'sexe'    => $row['sexe'],
            'email'    => $row['email'],
            'status'    => $row['status'],

            'cnss'=> $row['cnss'],
            'rib'=>$row['rib'],
            'bank_name'=> $row['bank_name'],
            'flotte'=> $row['flotte'],
            'date_embauche'=> $row['date_embauche'],
            'date_depart'=> $row['date_depart'],
            'departement'=> $row['departement'],
            'poste'=> $row['poste'],
            'societe'=> $row['societe'],
            'type_contrat'=> $row['type_contrat'],
            'salary'=> $row['salary'],
            'salary_net'=> $row['salary_net'],
            'salary_brut'=> $row['salary_brut'],
            'virement'=> $row['virement'],
            'date_virement'=> $row['date_virement'],
            'ir'=> $row['ir'],
            'tfp'=> $row['tfp'],
            'solde_conge'=> $row['solde_conge'],

            
            'dossier'=> $row['dossier'],
            'situation_familiale'=> $row['situation_familiale'],
            'num_personne_charge'=> $row['num_personne_charge'],
            'ville'=> $row['ville'],
            'periodicite'=> $row['periodicite'],
            'salaire_jrs'=> $row['salaire_jrs'],
            'conge_mois'=> $row['conge_mois'],
            'anciente'=> $row['anciente'],
            'adresse'=> $row['adresse'],
            'motif_depart'=> $row['motif_depart'],




        ]);
    }
}
