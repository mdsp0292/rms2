<?php

namespace App\Observers;

use App\Jobs\SendOpportunityUpdateEmailJob;
use App\Models\Opportunity;

class OpportunityObserver
{
    /**
     * Handle the Opportunity "created" event.
     *
     * @param Opportunity $opportunity
     * @return void
     */
    public function created(Opportunity $opportunity)
    {
        //
    }

    /**
     * Handle the Opportunity "updated" event.
     *
     * @param Opportunity $opportunity
     * @return void
     */
    public function updated(Opportunity $opportunity)
    {
        if($opportunity->isDirty('sales_stage')){
            $oldStatus = $opportunity->getOriginal('sales_stage');
            SendOpportunityUpdateEmailJob::dispatch($opportunity, $oldStatus)->afterCommit();
        }
    }

    /**
     * Handle the Opportunity "deleted" event.
     *
     * @param Opportunity $opportunity
     * @return void
     */
    public function deleted(Opportunity $opportunity)
    {
        //
    }

    /**
     * Handle the Opportunity "restored" event.
     *
     * @param Opportunity $opportunity
     * @return void
     */
    public function restored(Opportunity $opportunity)
    {
        //
    }

    /**
     * Handle the Opportunity "force deleted" event.
     *
     * @param Opportunity $opportunity
     * @return void
     */
    public function forceDeleted(Opportunity $opportunity)
    {
        //
    }
}
