<?php

namespace App\Addons\Freetrial;

use App\Addons\Freetrial\Models\FreetrialConfig;
use App\DTO\Store\ConfigOptionDTO;
use App\Models\Billing\Invoice;
use App\Models\Store\Product;
use App\Services\Store\RecurringService;

class FreetrialService
{
    public static function createInvoice(string $billing, Product $product, FreetrialConfig $config, array $data, array $options)
    {
        $days = setting('remove_pending_invoice', 0) != 0 ? setting('remove_pending_invoice') : 7;
        $invoice = Invoice::create([
            'customer_id' => auth('web')->id(),
            'due_date' => now()->addDays($days),
            'total' => 0,
            'subtotal' => 0,
            'tax' => 0,
            'setupfees' => 0,
            'currency' => currency(),
            'status' => 'pending',
            'notes' => 'Free trial',
            'paymethod' => 'none',
            'invoice_number' => Invoice::generateInvoiceNumber(),
        ]);
        $invoiceItem = $invoice->items()->create([
            'invoice_id' => $invoice->id,
            'quantity' => 1,
            'name' => __('free_trial::lang.invoice.name'),
            'description' => __('free_trial::lang.invoice.description', ['product' => $product->name, 'start' => $config->startDate()->format('d/m/y'), 'end' => $config->endDate()->format('d/m/y')]),
            'unit_price_ht' => 0,
            'unit_price_ttc' => 0,
            'unit_setup_ht' => 0,
            'unit_setup_ttc' => 0,
            'tax' => 0,
            'related_id' => $config->id,
            'type' => 'free_trial',
            'data' => $data,
        ]);
        $optionDtos = [];
        $currency = currency();
        $configoptions = $product->configoptions;
        foreach ($options as $key => $value) {
            $option = $configoptions->where('key', $key)->first();
            if ($option) {
                $optionDtos[] = new ConfigOptionDTO($option, $value, app(RecurringService::class)->addFromNow($billing));
            }
        }
        foreach ($optionDtos as $option) {
            if (($first = $option->option->getFirstPrice())->recurring != $billing) {
                $billing = $first;
            }
            $invoiceItem->invoice->items()->create([
                'invoice_id' => $invoice->id,
                'name' => $option->getBillingName($currency, $billing, $config->endDate()->toDate()),
                'description' => $option->getBillingDescription(),
                'quantity' => $option->quantity(),
                'unit_price_ht' => 0,
                'unit_price_ttc' => 0,
                'unit_setup_ht' => 0,
                'unit_setup_ttc' => 0,
                'total' => 0,
                'tax' => 0,
                'type' => 'config_option',
                'related_id' => $option->option->id,
                'data' => $option->data($currency, $billing, $config->endDate()),
                'parent_id' => $invoiceItem->id,
            ]);
        }
        $invoice->complete();
        $config->increment('current_allowed_services');
        $config->increment('trials');

        return $invoice;
    }
}
