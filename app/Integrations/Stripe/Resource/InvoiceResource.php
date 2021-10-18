<?php

namespace App\Integrations\Stripe\Resource;


use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\Invoice;

class InvoiceResource extends AbstractResource
{

    /**
     * @param string $stripeInvoiceId
     * @return bool|Invoice
     */
    public function retrieveStripeInvoice(string $stripeInvoiceId): false|Invoice
    {
        try {
            return $this->stripeClient->invoices->retrieve($stripeInvoiceId, []);
        } catch (ApiErrorException $e) {
            report($e);
            return false;
        }
    }

    /**
     * @param array $invoiceData
     * @return false|Invoice
     */
    public function createInvoice(array $invoiceData): bool|Invoice
    {
        try {
            return $this->stripeClient->invoices->create([$invoiceData]);
        } catch (ApiErrorException $e) {
            Log::error('StripeAPi error while creating Invoice ', [
                'invoiceData'  => $invoiceData,
                'Stripe_error' => $e->getJsonBody()['error'] ?? '',
            ]);
            return false;
        }
    }

    /**
     * @param $stripeInvoiceId
     * @return false|Invoice
     */
    public function finalizeInvoice($stripeInvoiceId)
    {
        try {
            return $this->stripeClient->invoices->finalizeInvoice(
                $stripeInvoiceId,
                ['auto_advance' => false]
            );
        } catch (ApiErrorException $e) {
            Log::error('StripeApi error while finalizing invoice ' . $e->getMessage(),
                [
                    'Stripe_error' => $e->getJsonBody()['error'] ?? '',
                    'trace'        => $e->getTraceAsString()
                ]);
            return false;
        }
    }

    /**
     * @param array $invoiceLineItems
     * @return bool
     */
    public function createInvoiceItems(array $invoiceLineItems): bool
    {
        try {
            $this->stripeClient->invoiceItems->create($invoiceLineItems);
            return true;

        } catch (ApiErrorException $e) {
            Log::error('StripeAPi error while creating InvoiceLineItems ',
                [
                    'lineItemData' => $invoiceLineItems,
                    'Stripe_error' => $e->getJsonBody()['error'] ?? '',
                ]
            );
            return false;
        }
    }
}
