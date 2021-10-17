<?php

namespace App\Jobs;

use App\Mail\OpportunityStageChanged;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOpportunityUpdateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Opportunity $opportunity, private string $oldStatus)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $oldStatusString = $this->opportunity->getSalesStagesSimple($this->oldStatus);
        $newStatusString = $this->opportunity->sales_stage_string;
        //send email to all owner
        $accountOwners = User::query()->whereOwner(1)->get();
        foreach ($accountOwners as $owner) {
            Mail::to($owner->email)->send(new OpportunityStageChanged($this->opportunity, $oldStatusString, $newStatusString));
        }

        //send email to referrer
        if (!empty($this->opportunity->account?->users?->email)) {
            Mail::to($this->opportunity->account->users->email)->send(new OpportunityStageChanged($this->opportunity, $oldStatusString, $newStatusString));
        }
    }
}
