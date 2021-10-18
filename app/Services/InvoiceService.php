<?php

namespace App\Services;

use App\Integrations\Stripe\Stripe;
use App\Models\Opportunity;
use App\Models\User;
use Carbon\Carbon;
use Stripe\Invoice;

class InvoiceService
{
    const INVOICE_DEFAULT_COLLECTION_METHOD = 'send_invoice';
    const DEFAULT_CURRENCY = 'aud';

    public function __construct(private Opportunity $opportunity, private string $accountStripeId)
    {
        //..
    }


    /**
     * @return false|Invoice
     */
    public function createAndFinalizeInvoice(): bool|Invoice
    {
        $invoiceData = $this->generateStripeInvoiceData();
        $invoiceLineItemData = $this->generateStripeInvoiceItems();

        $stripApi = new Stripe();
        $stripeInvoiceItems = $stripApi->invoive()->createInvoiceItems($invoiceLineItemData);

        if (!$stripeInvoiceItems) {
            return false;
        }

        $stripeInvoice = $stripApi->invoive()->createInvoice($invoiceData);
        if (!$stripeInvoice) {
            return false;
        }

        //no finalize the invoice
        return $stripApi->invoive()->finalizeInvoice($stripeInvoice->id);
    }

    /**
     * Stripe invoice data
     *
     * @return array
     */
    public function generateStripeInvoiceData()
    {
        $data = [
            'customer'             => $this->accountStripeId,
            'auto_advance'         => true,
            'collection_method'    => self::INVOICE_DEFAULT_COLLECTION_METHOD,
            'description'          => $this->opportunity->name,
            'statement_descriptor' => config('app.name') . ' Invoice',
            'metadata'             => [
                'opportunity_id' => $this->opportunity->id
            ],
            'due_date'             => $this->getInvoiceDueDate()
        ];

        $referralData = $this->getReferralAmountData();
        if (!is_null($referralData)) {
            $data['transfer_data'] = $referralData;
        }

        return $data;
    }

    /**
     * @return int
     */
    private function getInvoiceDueDate(): int
    {
        return Carbon::now()->lte($this->opportunity->sale_start)
            ? Carbon::parse($this->opportunity->sale_start)->getTimestamp()
            : Carbon::now()->addDay()->getTimestamp();
    }

    /**
     * @return array|null
     */
    private function getReferralAmountData(): ?array
    {
        //If no connect account dont pass referral value
        $referralUser = User::query()->whereId($this->opportunity->account->user_id)->first();
        if (empty($referralUser->stripe_connect_id)) {
            return null;
        }

        return [
            'destination' => $referralUser->stripe_connect_id,
            'amount'      => $this->opportunity->referral_amount * 100
        ];
    }

    /**
     * generate invoice line items for Stripe invoice
     *
     * @return array
     */
    public function generateStripeInvoiceItems()
    {
        return [
            'customer'            => $this->accountStripeId,
            'description'         => $this->opportunity->name,
            'currency'            => self::DEFAULT_CURRENCY,
            'quantity'            => 1,
            'unit_amount_decimal' => $this->opportunity->amount * 100 //amount is always inc GST
        ];
    }
}
