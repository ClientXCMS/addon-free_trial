<?php

namespace App\Addons\Freetrial\DTO;

use App\Addons\Freetrial\Models\FreetrialConfig;
use App\Models\Billing\InvoiceItem;
use App\Services\Billing\InvoiceService;

class FreetrialDTO
{
    private FreetrialConfig $config;

    private InvoiceItem $invoiceItem;

    public function __construct(int $configId, InvoiceItem $invoiceItem)
    {
        $this->config = FreetrialConfig::find($configId);
        $this->invoiceItem = $invoiceItem;
    }

    public function getConfig(): FreetrialConfig
    {
        return $this->config;
    }

    public function tryDeliver()
    {
        $services = InvoiceService::createServicesFromInvoiceItem($this->invoiceItem->invoice, $this->invoiceItem);
        foreach ($services as $service) {
            $service->attachMetadata('free_trial_config', $this->config->id);
            $service->attachMetadata('free_trial_type', $this->config->type);
        }

        return $services;
    }
}
