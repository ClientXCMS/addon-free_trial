<?php

namespace App\Addons\Freetrial\Controllers\Front;

use App\Addons\Freetrial\FreetrialService;
use App\Addons\Freetrial\Models\FreetrialConfig;
use App\Addons\Freetrial\Requests\ProcessFreetrialRequest;
use App\DTO\Store\ProductDataDTO;
use App\Helpers\Countries;
use App\Http\Controllers\Controller;
use App\Models\Store\Product;

class FreetrialController extends Controller
{
    public function config(Product $product)
    {
        $freetrial = FreetrialConfig::where('product_id', $product->id)->first();
        if (! $freetrial) {
            return back();
        }
        $context = ['product' => $product];
        if ($freetrial->max_allowed_services != 0 && $freetrial->max_allowed_services == $freetrial->current_allowed_services) {
            session()->flash('error', __('free_trial::lang.errors.max_allowed_services'));
        }
        if (auth('web')->guest() && ! session()->has('error')) {
            \session()->flash('error', __('store.checkout.mustbelogged'));
        }
        if (auth('web')->check()) {
            $services = auth('web')->user()->services()->where('product_id', $product->id)->count();
            if ($services >= $freetrial->max_services && $freetrial->max_services != 0) {
                session()->flash('error', __('free_trial::lang.errors.max_services'));
            }
        }

        if ($product->productType()->data($product) !== null) {
            $context['data_html'] = $product->productType()->data($product)->render(new ProductDataDTO($product, [], [], []));
        } else {
            $context['data_html'] = '';
        }
        $configoptions = $product->configoptions()->orderBy('sort_order')->get();
        $context['options_html'] = collect($configoptions)->map(function ($product) {
            return $product->render([]);
        })->implode('');
        $context['options_prices'] = collect($configoptions)->mapWithKeys(function ($product) {
            return [$product->key => ['pricing' => $product->getPricingArray(), 'key' => $product->key, 'type' => $product->type, 'step' => $product->step, 'unit' => $product->unit, 'title' => $product->name]];
        });
        $context['options'] = $configoptions;
        $context['billing'] = $product->getFirstPrice()->recurring;
        $context['countries'] = Countries::names();

        if (app('extension')->extensionIsEnabled('socialauth')) {
            $providers = \App\Addons\SocialAuth\Models\ProviderEntity::where('enabled', true)->get();
        } else {
            $providers = collect([]);
        }
        $context['providers'] = $providers;
        $context['free_trial'] = $freetrial;

        return view('free_trial::config', $context);
    }

    public function process(Product $product, ProcessFreetrialRequest $request)
    {
        $freetrial = FreetrialConfig::where('product_id', $product->id)->first();
        if (! $freetrial) {
            return back();
        }

        if ($freetrial->max_allowed_services != 0 && $freetrial->max_allowed_services == $freetrial->current_allowed_services) {
            return back()->with('error', __('free_trial::errors.max_allowed_services'));
        }
        if (auth('web')->guest()) {
            session()->flash('warning', __('store.checkout.mustbelogged'));

            return back()->with('warning', __('store.checkout.mustbelogged'));
        }

        if (auth('web')->check()) {
            $services = auth('web')->user()->services()->where('product_id', $product->id)->count();
            if ($services >= $freetrial->max_services && $freetrial->max_services != 0) {
                return back()->with('error', __('free_trial::lang.errors.max_services'));
            }
        }
        if (auth('web')->user() && auth('web')->user()->hasVerifiedEmail() !== true && setting('checkout.customermustbeconfirmed', false) === true) {
            session()->flash('warning', __('store.checkout.mustbeconfirmed'));

            return back()->with('warning', __('store.checkout.mustbeconfirmed'));
        }
        $data = $request->getData();
        $options = $request->getOptions();
        $invoice = FreetrialService::createInvoice($request->validated('billing'), $product, $freetrial, $data, $options);

        return redirect()->to(route('front.invoices.show', $invoice));
    }
}
