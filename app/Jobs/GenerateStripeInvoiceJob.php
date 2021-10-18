<?php

namespace App\Jobs;

use App\Integrations\Stripe\Stripe;
use App\Models\Opportunity;
use App\Services\AccountService;
use App\Services\InvoiceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateStripeInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Opportunity $opportunity)
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
        $accountStripeId = (new AccountService)->getAccountStripeId($this->opportunity->account);

        if(!$accountStripeId){
            Log::error('Error creating invoice for opportunity '.$this->opportunity->id .' customer not found in stripe');
            return;
        }

        $invoiceService = new InvoiceService($this->opportunity, $accountStripeId);
        $result = $invoiceService->createAndFinalizeInvoice();

        if($result){
            $this->opportunity->sales_stage = Opportunity::STAGE_INVOICE_GENERATED;
            $this->opportunity->saveQuietly();
        }

    }
}
