<?php

namespace App\Observers;

use App\Models\CreditSalaire;

class CreditSalaireObserver
{
    /**
     * Handle the CreditSalaire "created" event.
     *
     * @param  \App\Models\CreditSalaire  $creditSalaire
     * @return void
     */
    public function created(CreditSalaire $creditSalaire)
    {
        //
    }

    /**
     * Handle the CreditSalaire "updated" event.
     *
     * @param  \App\Models\CreditSalaire  $creditSalaire
     * @return void
     */
    public function updating(CreditSalaire $creditSalaire)
    {
        //
        if ($creditSalaire->isDirty('restant') && $creditSalaire->restant === 0) {
            $creditSalaire->status = 1;
        }
    }

    /**
     * Handle the CreditSalaire "deleted" event.
     *
     * @param  \App\Models\CreditSalaire  $creditSalaire
     * @return void
     */
    public function deleted(CreditSalaire $creditSalaire)
    {
        //
    }

    /**
     * Handle the CreditSalaire "restored" event.
     *
     * @param  \App\Models\CreditSalaire  $creditSalaire
     * @return void
     */
    public function restored(CreditSalaire $creditSalaire)
    {
        //
    }

    /**
     * Handle the CreditSalaire "force deleted" event.
     *
     * @param  \App\Models\CreditSalaire  $creditSalaire
     * @return void
     */
    public function forceDeleted(CreditSalaire $creditSalaire)
    {
        //
    }
}
