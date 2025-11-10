@php($config = \App\Addons\Freetrial\Models\FreetrialConfig::where('product_id', $product->id)->first())
@if ($config != null)
    <div class="flex justify-center mb-4">
        <span class="inline-flex items-center gap-x-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            {{ __('free_trial::lang.config.can_trial', ['days' => $config->trial_days]) }}
        </span>
    </div>
@endif
