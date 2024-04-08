<?php

namespace App\Observers;

use App\Models\DemandeAchat;
use App\Models\HistoriquePurchaseOrder;

class DemandeAchatObserver
{
    /**
     * Handle the DemandeAchat "created" event.
     */
    public function created(DemandeAchat $demandeAchat): void
    {

        HistoriquePurchaseOrder::create([
            'purchase_order_id' => $demandeAchat->id,
            'title' => $demandeAchat->type == 'Achats' ? 'Création de la demande d\'achat' : 'Création de la demande d\'exécution',
            'description' => ($demandeAchat->type == 'Achats' ? 'La demande d\'achat a été créée par ' : 'La demande d\'exécution a été créée par') . auth('api')->user()->employee->first_name . ' ' . auth('api')->user()->employee->last_name,
        ]);
    }

    /**
     * Handle the DemandeAchat "updated" event.
     */
    public function updated(DemandeAchat $demandeAchat): void
    {
        if ($demandeAchat->isDirty('status')) {
            if ($demandeAchat->status === 'en cours') {
                if ($demandeAchat->type == 'Achats') {
                    HistoriquePurchaseOrder::create([
                        'purchase_order_id' => $demandeAchat->id,
                        'title' => 'Table comparatif créée',
                        'description' => 'La table comparatif a été créée par ' . auth('api')->user()->employee->first_name . ' ' . auth('api')->user()->employee->last_name,
                    ]);
                }
                if ($demandeAchat->type == 'Service') {
                    HistoriquePurchaseOrder::create([
                        'purchase_order_id' => $demandeAchat->id,
                        'title' => 'La demande d\'exécution validée',
                        'description' => 'La demande d\'exécution a été validée par ' . auth('api')->user()->employee->first_name . ' ' . auth('api')->user()->employee->last_name,
                    ]);
                }
            }
        }
    }

    /**
     * Handle the DemandeAchat "deleted" event.
     */
    public function deleted(DemandeAchat $demandeAchat): void
    {
        //
    }

    /**
     * Handle the DemandeAchat "restored" event.
     */
    public function restored(DemandeAchat $demandeAchat): void
    {
        //
    }

    /**
     * Handle the DemandeAchat "force deleted" event.
     */
    public function forceDeleted(DemandeAchat $demandeAchat): void
    {
        //
    }
}
