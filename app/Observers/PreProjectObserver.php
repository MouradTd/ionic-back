<?php

namespace App\Observers;

use App\Mail\NotifyDirection;
use App\Mail\NotifyFinance;
use App\Models\Caution;
use App\Models\Client;
use App\Models\MailList;
use App\Models\PreProject;
use App\Models\PreProjectHistory;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PreProjectObserver
{
    /**
     * Handle the PreProject "created" event.
     */
    public function created(PreProject $preProject): void
    {
        PreProjectHistory::create([
            'pre_project_id' => $preProject->id,
            'title' => 'Création du projet',
            'description' => 'Le projet a été créé avec succès par ' . auth('api')->user()->employee->first_name . ' ' . auth('api')->user()->employee->last_name,
        ]);
    }

    /**
     * Handle the PreProject "updated" event.
     */
    public function updated(PreProject $preProject): void
    {
        DB::beginTransaction();
        // Scenario 1: When the project is validated
        if ($preProject->status === 'Validé' && $preProject->isDirty('status')) {
            PreProjectHistory::create([
                'pre_project_id' => $preProject->id,
                'title' => 'Validation du l/\'avant projet',
                'description' => 'L\'avant projet a été validé par ' . auth('api')->user()->employee->first_name . ' ' . auth('api')->user()->employee->last_name,
            ]);

            if ($preProject->is_caution_auto === 1) {
                Caution::create([
                    'pre_project_id' => $preProject->id,
                    'caution_type' => 'provisoire',
                    'amount' => $preProject->montant_caution,
                    'status' => 0,
                    'bank_account_id' => 1,
                ]);
                // TODO : send a mail to the finance department
            }
        }

        // Scenario 2: When the project is rejected
        if ($preProject->status === 'Rejeté' && $preProject->isDirty('status')) {
            PreProjectHistory::create([
                'pre_project_id' => $preProject->id,
                'title' => 'Rejet du l/\'avant projet',
                'description' => 'L\'avant projet a été rejeté par ' . auth('api')->user()->employee->first_name . ' ' . auth('api')->user()->employee->last_name,
            ]);
        }

        // Scenario 3 : When the project canceled
        if ($preProject->status === 'Annulé' && $preProject->isDirty('status')) {
            PreProjectHistory::create([
                'pre_project_id' => $preProject->id,
                'title' => 'Annulation du l/\'avant projet',
                'description' => 'L\'avant projet a été annulé par ' . auth('api')->user()->employee->first_name . ' ' . auth('api')->user()->employee->last_name,
            ]);
        }

        // Scenario 4: When the project is mark as win
        if ($preProject->status === 'Gagné' && $preProject->isDirty('status')) {
            PreProjectHistory::create([
                'pre_project_id' => $preProject->id,
                'title' => 'Creation du projet',
                'description' => 'L\'avant projet a été transformé en projet par ' . User::find(8)->employee->first_name . ' ' . User::find(8)->employee->last_name,
            ]);

            $client = Client::firstOrCreate(['raison_social' => $preProject->maitre_ouvrage],['raison_social' => $preProject->maitre_ouvrage]);

            Project::create([
                'pre_project_id' =>  $preProject->id,
                'code' => $preProject->project_code,
                'date_start' => now(),
                'budget' => $preProject->montant_marche,
                'client_id' => $client->id,
            ]);

            /* Mail::to(MailList::where([['type','finance'],['is_active',true]])->get('email'))->send(new NotifyFinance($preProject));
            Mail::to(MailList::where([['type','direction'],['is_active',true]])->get('email'))->send(new NotifyDirection($preProject)); */
        }

        // Scenarion 5 : When the project is mark as lose
        if ($preProject->status === 'Perdu' && $preProject->isDirty('status')) {
            PreProjectHistory::create([
                'pre_project_id' => $preProject->id,
                'title' => 'Rejet du l/\'avant projet',
                'description' => 'L\'avant projet a été rejeté par ' . auth('api')->user()->employee->first_name . ' ' . auth('api')->user()->employee->last_name,
            ]);
        }

        DB::commit();
    }

    /**
     * Handle the PreProject "deleted" event.
     */
    public function deleted(PreProject $preProject): void
    {
        //
    }

    /**
     * Handle the PreProject "restored" event.
     */
    public function restored(PreProject $preProject): void
    {
        //
    }

    /**
     * Handle the PreProject "force deleted" event.
     */
    public function forceDeleted(PreProject $preProject): void
    {
        //
    }
}
