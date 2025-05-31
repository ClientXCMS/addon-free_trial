@php($gateways = \App\Services\Store\GatewayService::getAvailable($service->getBillingPrice()->price))
@if ($service->hasMetadata('free_trial_type') && $service->trial_ends_at != null)
    @if ($service->getMetadata('free_trial_type') == 'free')
        <div class="card mt-2">
        @if (collect($service->pricingAvailable())->count() > 1)

            <form method="POST" action="{{ route('front.services.billing', ['service' => $service]) }}">
                @csrf

                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('free_trial::lang.service.free.title') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                    {{ __('free_trial::lang.service.free.subheading', ['date' => $service->trial_ends_at->format('d/m/y'), 'date2' => $service->expires_at->addDays(setting('days_before_expiration'))->format('d/m/y')]) }}
                </p>
                <ul class="flex flex-col sm:flex-row w-full">
                    @foreach(collect($service->pricingAvailable()) as $pricing)
                        <li class="inline-flex items-center gap-x-2.5 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg sm:-ms-px sm:mt-0 sm:first:rounded-se-none sm:first:rounded-es-lg sm:last:rounded-es-none sm:last:rounded-se-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                            <div class="relative flex items-start w-full">
                                <div class="flex items-center h-5">
                                    <input id="months-{{ $pricing->recurring }}" @if($service->billing == $pricing->recurring) checked="checked" @endif name="billing" value="{{ $pricing->recurring }}" type="radio" class="border-gray-200 rounded-full disabled:opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                </div>
                                <label for="months-{{ $pricing->recurring }}" class="ms-3 block w-full text-sm text-gray-600 dark:text-gray-500">
                                    {{ $pricing->recurring()['months'] == 0.5 ? 1 : $pricing->recurring()['months'] }} {{ $pricing->recurring()['months'] == 0.5 ? __('global.week') : __('global.month') }} - {{ $pricing->pricingMessage(false) }}
                                </label>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-2">
                    @foreach ($gateways as $gateway)
                        <div class="flex p-1">
                            <input type="radio" {{ $loop->first ? 'checked'  : ''}} name="gateway" value="{{ $gateway->uuid  }}" id="gateway-{{ $gateway->uuid }}" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <label for="gateway-{{ $gateway->uuid }}" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">{{ $gateway->name }}</label>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-primary mt-2" name="pay">{{ __('client.services.renewbtn') }}</button>
            </form>
        @else
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                {{ __('client.services.renewals.not_autorized_to_change_billing') }}
            </p>
        @endif
        </div>
    @else
        @php($products = $service->product->getUpgradeProducts())
        <div class="card mt-2">

            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('free_trial::lang.service.trial.title') }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                {{ __('free_trial::lang.service.trial.subheading', ['date' => $service->trial_ends_at->format('d/m/y'), 'date2' => $service->expires_at->addDays(setting('days_before_expiration'))->format('d/m/y')]) }}
            </p>
            @foreach($products->chunk(3) as $row)

                <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:items-center">
                    @foreach($row as $product)
                        <div>
                            @if($product->pinned)
                                @include('shared.products.pinned', ['billing' => $service->billing, 'basket_url' => route('front.services.upgrade_process', ['service' => $service, 'product' => $product]), 'showSetup' => false, 'basket_title' => __('client.services.upgrade.upgradebtn')])
                            @else
                                @include('shared.products.product', ['billing' => $service->billing, 'basket_url' => route('front.services.upgrade_process', ['service' => $service, 'product' => $product]), 'showSetup' => false, 'basket_title' => __('client.services.upgrade.upgradebtn')])
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        @endif
@endif
