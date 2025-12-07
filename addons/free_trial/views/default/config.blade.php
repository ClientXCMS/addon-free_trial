<?php
/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
?>
@extends('layouts/front')
@section('title', $product->name)
@section('scripts')
    <script src="{{ Vite::asset('resources/themes/default/js/basket.js') }}" type="module"></script>
    <script src="{{ Vite::asset('resources/themes/default/js/checkout.js') }}" type="module" defer></script>

@endsection
@section('content')

    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="grid grid-cols-3 gap-4">
            @if (Auth::guest())
                <div class="col-span-3 md:col-span-2">
                    <form id="basket-config-form" data-pricing-endpoint="{{ route('front.store.basket.config.preview', ['product' => $product]) }}" method="POST" action="{{ route('free_trial.config', ['product' => $product]) }}{{(request()->getQueryString() != null ? '?' . request()->getQueryString() : '')}}">
                        <input type="hidden" name="currency" value="{{ currency() }}" id="currency">
                        @csrf
                        @include("shared.alerts")
                        <h1 class="text-2xl font-semibold mb-4 dark:text-white">{{ __('free_trial::lang.config.title') }}</h1>
                        @php($pricings = $product->pricingAvailable(currency()))
                        <div class="grid sm:grid-cols-3 gap-2 card" id="basket-billing-section">
                            <div class="col-span-3">
                                <h2 class="text-lg font-semibold mb-4">{{ __('store.config.billing') }}</h2>
                            </div>
                            @foreach ($pricings as $pricing)
                                <label for="billing-{{ $pricing->recurring }}-{{ $pricing->currency }}" class="col-span-3 md:col-span-1 p-3 block w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                    <span class="dark:text-gray-400 font-semibold">@if ($pricing->isFree()){{ __('global.free') }} @else {{ $pricing->getPriceByDisplayMode() }} {{ $pricing->getSymbol() }} @endif {{ $pricing->recurring()['translate'] }}<p class="text-gray-500">{{ $pricing->pricingMessage() }} @if ($pricing->hasDiscountOnRecurring($product->getFirstPrice()))<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">-{{ $pricing->getDiscountOnRecurring($product->getFirstPrice()) }}%</span>@endif</p></span>
                                    <input type="radio" name="billing" value="{{ $pricing->recurring }}" {{ ($billing == $pricing->recurring) || $loop->first ? 'checked' : '' }} data-pricing="{{ $pricing->toJson()  }}" class="shrink-0 ms-auto mt-0.5 border-gray-200 rounded-full text-indigo-600 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-indigo-600 dark:checked:border-indigo-600 dark:focus:ring-offset-gray-800" id="billing-{{ $pricing->recurring }}-{{ $pricing->currency }}">
                                </label>
                            @endforeach
                        </div>
                        @if (!empty($options_html))
                            <div class="card border-b border-gray-900/10 pb-6">
                                <h2 class="text-lg font-semibold">{{ __('store.config.options') }}</h2>
                                {!! $options_html !!}
                            </div>
                        @endif
                        @if (!empty($data_html))
                            <div class="card border-b border-gray-900/10 pb-6">

                                {!! $data_html !!}
                            </div>
                        @endif
                        <div class="card">
                            <button type="button" class="hs-collapse-toggle py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" id="login-collapse-collapse" data-hs-collapse="#login-collapse-heading">
                                {{ __('auth.login.btn') }}
                            </button>
                            <button type="button" class="hs-collapse-toggle py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-100 text-indigo-800 hover:bg-indigo-200 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-indigo-900 dark:text-indigo-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" id="register-collapse-collapse" data-hs-collapse="#register-collapse-heading">
                                {{ __('auth.register.btn') }}
                            </button>
                            <div id="login-collapse-heading" class="hs-collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="login-collapse">
                                <div class="mt-5">

                                    @if ($providers->isNotEmpty())
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                            @foreach ($providers as $provider)
                                                <a href="{{ route('socialauth.authorize', $provider->name) }}" class="mt-2 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">

                                                    <img src="{{ $provider->provider()->logo() }}" alt="{{ $provider->provider()->title() }}" class="w-5 h-5" />
                                                    {{ __('socialauth::messages.login_with', ['provider' => $provider->provider()->title()]) }}
                                                </a>
                                            @endforeach
                                        </div>

                                        <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 before:me-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 after:ms-6 dark:text-gray-500 dark:before:border-gray-600 dark:after:border-gray-600">
                                            {{ trans("global.or") }}</div>
                                    @endif
                                    <form method="POST" action="{{ route('login') }}">
                                        @include('shared.auth.login', ['redirect' => route('free_trial.config', ['product' => $product]) .'#login', 'captcha' => true])
                                    </form>
                                </div>
                            </div>

                            <div id="register-collapse-heading" class="hs-collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="register-collapse">
                                <div class="mt-5">
                                    @if ($providers->isNotEmpty())
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach ($providers as $provider)
                                                <a href="{{ route('socialauth.authorize', $provider->name) }}" class="mt-2 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">

                                                    <img src="{{ $provider->provider()->logo() }}" alt="{{ $provider->provider()->title() }}" class="w-5 h-5" />
                                                    {{ __('socialauth::messages.register_with', ['provider' => $provider->provider()->title()]) }}
                                                </a>
                                            @endforeach
                                        </div>

                                        <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 before:me-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 after:ms-6 dark:text-gray-500 dark:before:border-gray-600 dark:after:border-gray-600">
                                            {{ trans("global.or") }}</div>
                                    @endif
                                    <p class="text-gray-500 dark:text-gray-400">
                                        @include('shared.auth.register', ['countries' => $countries, 'redirect' => route('free_trial.config', ['product' => $product]) . '#register'])
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="col-span-3 md:col-span-2">
                    <form id="basket-config-form" data-pricing-endpoint="{{ route('front.store.basket.config.preview', ['product' => $product]) }}" method="POST" action="{{ route('free_trial.config', ['product' => $product]) }}{{(request()->getQueryString() != null ? '?' . request()->getQueryString() : '')}}">
                        <input type="hidden" name="currency" value="{{ currency() }}" id="currency">
                        @csrf
                        @include("shared.alerts")
                        <h1 class="text-2xl font-semibold mb-4 dark:text-white">{{ __('free_trial::lang.config.title') }}</h1>
                        @php($pricings = $product->pricingAvailable(currency()))
                        <div class="grid sm:grid-cols-3 gap-2 card" id="basket-billing-section">
                            <div class="col-span-3">
                                <h2 class="text-lg font-semibold mb-4">{{ __('store.config.billing') }}</h2>
                            </div>
                            @foreach ($pricings as $pricing)
                                <label for="billing-{{ $pricing->recurring }}-{{ $pricing->currency }}" class="col-span-3 md:col-span-1 p-3 block w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                    <span class="dark:text-gray-400 font-semibold">@if ($pricing->isFree()){{ __('global.free') }} @else {{ $pricing->getPriceByDisplayMode() }} {{ $pricing->getSymbol() }} @endif {{ $pricing->recurring()['translate'] }}<p class="text-gray-500">{{ $pricing->pricingMessage() }} @if ($pricing->hasDiscountOnRecurring($product->getFirstPrice()))<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">-{{ $pricing->getDiscountOnRecurring($product->getFirstPrice()) }}%</span>@endif</p></span>
                                    <input type="radio" name="billing" value="{{ $pricing->recurring }}" {{ ($billing == $pricing->recurring) || $loop->first ? 'checked' : '' }} data-pricing="{{ $pricing->toJson()  }}" class="shrink-0 ms-auto mt-0.5 border-gray-200 rounded-full text-indigo-600 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-indigo-600 dark:checked:border-indigo-600 dark:focus:ring-offset-gray-800" id="billing-{{ $pricing->recurring }}-{{ $pricing->currency }}">
                                </label>
                            @endforeach
                        </div>
                        @if (!empty($options_html))
                            <div class="card border-b border-gray-900/10 pb-6">
                                <h2 class="text-lg font-semibold">{{ __('store.config.options') }}</h2>
                                {!! $options_html !!}
                            </div>
                        @endif
                        @if (!empty($data_html))
                            <div class="card border-b border-gray-900/10 pb-6">

                                {!! $data_html !!}
                            </div>
                        @endif
                        <div class="card">
                            <div class="flex justify-between mb-2 text-gray-400">
                                <span>{{ __('auth.signed_in_as') }}</span>
                                <span>{{ Auth::user()->FullName }} ({{ Auth::user()->email }})</span>
                            </div>
                            @if (Auth::user()->hasVerifiedEmail() && setting('checkout.customermustbeconfirmed', false))
                                <div class="bg-gray-50 border border-gray-200 text-sm text-gray-600 rounded-lg p-4 dark:bg-white/10 dark:border-white/10 dark:text-neutral-400" role="alert" tabindex="-1" aria-labelledby="hs-link-on-right-label">
                                    <div class="flex">
                                        <div class="shrink-0">
                                            <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="M12 16v-4"></path>
                                                <path d="M12 8h.01"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 md:flex md:justify-between ms-2 my-auto">
                                            <p id="hs-link-on-right-label" class="text-sm">
                                                {{ __('store.checkout.email_must_be_verified') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @csrf

                            <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    @include("shared.input", ["name" => "firstname", "label" => __('global.firstname'), "value" => auth('web')->user()->firstname ?? old("firstname")])
                                </div>

                                <div class="sm:col-span-3">
                                    @include("shared.input", ["name" => "lastname", "label" => __('global.lastname'), "value" => auth('web')->user()->lastname ?? old("lastname")])
                                </div>

                                <div class="sm:col-span-3">
                                    @include("shared.input", ["name" => "address", "label" => __('global.address'), "value" => auth('web')->user()->address ?? old("address")])
                                </div>
                                <div class="sm:col-span-2">
                                    @include("shared.input", ["name" => "address2", "label" => __('global.address2'), "value" => auth('web')->user()->address2 ?? old("address2")])
                                </div>

                                <div class="sm:col-span-1">
                                    @include("shared.input", ["name" => "zipcode", "label" => __('global.zip'), "value" => auth('web')->user()->zipcode ?? old("zipcode")])
                                </div>

                                <div class="sm:col-span-3">
                                    @include("shared.input", ["name" => "email", "label" => __('global.email'), "type" => "email", "value" => auth('web')->user()->email ?? old("email"), "disabled"=> true])
                                </div>


                                <div class="sm:col-span-3">
                                    @include("shared.input", ["name" => "phone", "label" => __('global.phone'), "value" => auth('web')->user()->phone ?? old("phone")])
                                </div>

                                <div class="sm:col-span-2">
                                    @include("shared.select", ["name" => "country", "label" => __('global.country'), "options" => $countries,"value" => auth('web')->user()->country ?? old("country")])
                                </div>

                                <div class="sm:col-span-2">
                                    @include("shared.input", ["name" => "city", "label" => __('global.city'), "value" => auth('web')->user()->city ?? old("city")])
                                </div>

                                <div class="sm:col-span-2">
                                    @include("shared.input", ["name" => "region", "label" => __('global.region'), "value" => auth('web')->user()->region ?? old("region")])
                                </div>
                            </div>

                            @if (setting('checkout.toslink'))
                                <div class="sm:col-span-3 flex gap-x-6 mb-2 mt-3">
                                    <div class="flex h-6 items-center">
                                        <input id="accept_tos" name="accept_tos" type="checkbox" class="h-4 w-4 rounded border-gray-300 @error("accept_tos") border-red-300 @enderror text-indigo-600 focus:ring-indigo-600">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="accept_tos" class="font-medium @error("accept_tos") text-red-300 dark:text-red-500 @else text-gray-900 dark:text-white @enderror">{{ __('auth.register.accept') }} <a href="{{ setting('checkout.toslink') }}" class="text-indigo-600">{{ __('store.checkout.terms') }}</a></label>
                                    </div>
                                </div>
                            @endif
                            @include('shared/captcha', ['center' => false])
                        </div>
                    </form>
                </div>
            @endif
            <div class="col-span-3 md:col-span-1">
                <div class="card dark:text-gray-400">
                    <h2 class="text-lg font-semibold  dark:text-gray-300 mb-4">{{ __('store.config.summary') }}</h2>
                    <div id="basket-config-error" class="text-sm text-red-600 mb-3 hidden"></div>
                    
                    <div class="flex justify-between mb-2">
                        <span>{{ __('global.product') }}</span>
                        <span>{{ $product->name }}</span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>{{ __('free_trial::lang.config.period') }}</span>
                        <span>{{ $free_trial->startDate()->format('d/m/y') }} - {{ $free_trial->endDate()->format('d/m/y') }}</span>
                    </div>
                    @if ($options->isNotEmpty())
                        <hr class="my-2">
                        @foreach ($options as $option)
                            <div class="flex justify-between mb-2">
                                <span id="options_name[{{ $option->key }}]" data-name="{{ $option->name }}">{{ $option->name }}</span>
                                <span id="options_price[{{ $option->key }}]">0</span>
                            </div>
                        @endforeach
                        <hr class="my-2">
                    @endif
                    <div class="flex justify-between mb-2">
                        <span>{{ __('store.config.recurring_payment') }}</span>
                        <span id="recurring">0</span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>{{ __('store.config.onetime_payment') }}</span>
                        <span id="onetime">0</span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>{{ __('store.fees') }}</span>
                        <span id="fees">0</span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>{{ __('store.subtotal') }}</span>
                        <span id="subtotal">0</span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span>{{ __('store.vat') }}</span>
                        <span id="taxes">0</span>
                    </div>
                    <hr class="my-2">

                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">{{ __('free_trial::lang.config.total_now') }}</span>
                        <span class="font-semibold">{{ formatted_price(0) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">{{ __('free_trial::lang.config.total_after_trial') }}</span>
                        <span class="font-semibold" id="total">0</span>
                    </div>
                    <button class="bg-indigo-600 text-white py-2 px-4 rounded-lg mt-4 w-full" onclick="document.querySelector('#basket-config-form').submit()">{{ __('free_trial::lang.config.start') }}</button>
                    <p class="text-gray-500">{{ __('free_trial::lang.config.details', ['days' => setting('days_before_expiration')]) }}</p>
                </div>
            </div>
        </div>
    </div>


@endsection
