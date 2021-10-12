<?php

namespace App\Observers;

use App\Models\Opportunity;

class OpportunityObserver
{
    /**
     * Handle the Opportunity "created" event.
     *
     * @param  \App\Models\Opportunity  $opportunity
     * @return void
     */
    public function created(Opportunity $opportunity)
    {
        //
    }

    /**
     * Handle the Opportunity "updated" event.
     *
     * @param  \App\Models\Opportunity  $opportunity
     * @return void
     */
    public function updated(Opportunity $opportunity)
    {
        //
    }

    /**
     * Handle the Opportunity "deleted" event.
     *
     * @param  \App\Models\Opportunity  $opportunity
     * @return void
     */
    public function deleted(Opportunity $opportunity)
    {
        //
    }

    /**
     * Handle the Opportunity "restored" event.
     *
     * @param  \App\Models\Opportunity  $opportunity
     * @return void
     */
    public function restored(Opportunity $opportunity)
    {
        //
    }

    /**
     * Handle the Opportunity "force deleted" event.
     *
     * @param  \App\Models\Opportunity  $opportunity
     * @return void
     */
    public function forceDeleted(Opportunity $opportunity)
    {
        //
    }
}
