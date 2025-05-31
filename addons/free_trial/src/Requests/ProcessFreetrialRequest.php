<?php

namespace App\Addons\Freetrial\Requests;

use App\Contracts\Store\ProductTypeInterface;
use App\DTO\Store\ProductDataDTO;
use App\Http\Requests\ProcessCheckoutRequest;
use App\Services\Store\CurrencyService;
use Illuminate\Validation\Rule;

class ProcessFreetrialRequest extends ProcessCheckoutRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['gateway']);

        $authorizedBilling = collect($this->product->pricingAvailable())->map(function ($price) {
            return $price->recurring;
        })->unique()->toArray();
        /** @var ProductTypeInterface $productType */
        $productType = $this->product->productType();
        $rules = array_merge($rules, [
            'billing' => ['required', 'string', Rule::in($authorizedBilling)],
            'currency' => ['required', 'string', Rule::in(app(CurrencyService::class)->getCurrenciesKeys())],
        ]);
        if ($productType->data($this->product) !== null) {
            $rules = array_merge($rules, $productType->data($this->product)->validate());
        }
        $configOptions = $this->product->configoptions()->orderBy('sort_order')->get();
        foreach ($configOptions as $configOption) {
            $rules['options.'.$configOption->key] = $configOption->validate();
        }

        return $rules;
    }

    public function getOptions(): array
    {
        return array_filter($this->get('options', []), function ($value) {
            return $value !== null && $value !== '' && $value !== '0';
        });
    }

    public function getData(): array
    {
        /** @var ProductTypeInterface $productType */
        $productType = $this->product->productType();
        $data = $productType->data($this->product);
        if ($data == null) {
            return [];
        }
        $only = $data->parameters(new ProductDataDTO($this->product, [], $this->validated(), $this->getOptions()));
        return array_filter($only, function ($value) {
            return $value !== null && $value !== '' && $value !== '0';
        });
    }
}
