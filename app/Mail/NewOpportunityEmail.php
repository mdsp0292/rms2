<?php

namespace App\Mail;

use App\Models\Opportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOpportunityEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private Opportunity $opportunity)
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
        return $this->markdown('emails.opportunity.new',[
            'opportunityName'   => $this->opportunity->name,
            'opportunityAmount' => $this->opportunity->referral_amount,
            'accountName'       => $this->opportunity->account->name
        ])->subject('New opportunity created');
    }
}
