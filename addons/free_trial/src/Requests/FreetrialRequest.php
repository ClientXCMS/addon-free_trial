<?php

namespace App\Addons\Freetrial\Requests;

use App\Addons\Freetrial\Models\FreetrialConfig;
use App\Models\Store\Product;
use Illuminate\Foundation\Http\FormRequest;

class FreetrialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'type' => 'in:free,trial,simple',
            'max_services' => 'integer|required',
            'trial_days' => 'integer|required',
            'current_allowed_services' => 'integer|nullable',
            'max_allowed_services' => 'integer|required',
            'force' => 'nullable|in:yes,no',
        ];
    }

    public function store()
    {
        $validated = $this->validated();
        if (array_key_exists('force', $validated)) {
            unset($validated['force']);
        }
        $created = FreetrialConfig::create($validated);
        /** @var Product $product */
        $product = Product::find($this->validated('product_id'));
        if ($this->get('force') == 'yes') {
            $product->attachMetadata('basket_url', route('free_trial.config', ['product' => $product]));
            $product->attachMetadata('basket_title', 'free_trial::lang.trialbtn');
        } else {
            $product->detachMetadata('basket_url');
            $product->detachMetadata('basket_title');
        }
        if ($this->validated('max_services')) {
            $product->attachMetadata('allow_only_as_much_services', 'all:'.$this->validated('max_services'));
        }

        return $created;
    }

    public function update()
    {
        $validated = $this->validated();
        if (array_key_exists('force', $validated)) {
            unset($validated['force']);
        }

        $freetrial = $this->route('free_trial');
        $freetrial->update($validated);
        $product = Product::find($this->validated('product_id'));
        if ($this->get('force') == 'yes') {
            $product->attachMetadata('basket_url', route('free_trial.config', ['product' => $product]));
            $product->attachMetadata('basket_title', 'free_trial::lang.trialbtn');
        } else {
            $product->detachMetadata('basket_url');
            $product->detachMetadata('basket_title');
        }

        return $freetrial;
    }
}
