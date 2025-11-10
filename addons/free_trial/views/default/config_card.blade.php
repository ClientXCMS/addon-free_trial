@php($config = \App\Addons\Freetrial\Models\FreetrialConfig::where('product_id', $product->id)->first())
@if ($config != null)
    <div class="card">
        <div class="flex flex-auto flex-col justify-center items-center p-4 md:p-5">
            @include("shared.icons.shopping-cart")
            <h3>{{ __('free_trial::lang.config.want_trial') }}</h3>
            <p class="mt-5 text-sm text-gray-800 dark:text-gray-400">
                {{ __('free_trial::lang.config.can_trial', ['days' => $config->trial_days]) }}
            </p>
            <a href="{{ route('free_trial.config', ['product' => $product]) }}" class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-indigo-600 hover:text-indigo-800 disabled:opacity-50 disabled:pointer-events-none dark:text-indigo-500 dark:hover:text-indigo-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">{{ __('free_trial::lang.config.title') }}</a>
        </div>
    </div>
@endif
