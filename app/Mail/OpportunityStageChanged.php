<?php

namespace App\Mail;

use App\Models\Opportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OpportunityStageChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private Opportunity $opportunity, private string $oldStatus, private string $newStatus)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.opportunity.updated', [
            'opportunityName'   => $this->opportunity->name,
            'opportunityAmount' => $this->opportunity->referral_amount,
            'accountName'       => $this->opportunity->account->name,
            'oldStatus'         => $this->oldStatus,
            'newStatus'         => $this->newStatus
        ]);
    }
}
