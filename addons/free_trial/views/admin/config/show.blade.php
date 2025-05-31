<?php
/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
?>
@extends('admin/layouts/admin')
@section('title',  __($translatePrefix . '.show.title', ['name' => $item->name]))
@section('content')
<div class="max-w-[85rem] py-5 lg:py-7 mx-auto">
    <div class="mx-auto">
        @include('shared/alerts')
        <form method="POST" class="card" action="{{ route($routePath . '.update', ['free_trial' => $item]) }}">
            <div class="card-heading">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ __($translatePrefix . '.show.title', ['name' => $item->name]) }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __($translatePrefix. '.show.subheading', ['date' => $item->created_at == null ? 'None' : $item->created_at->format('d/m/y')]) }}
                    </p>
                </div>

                <div class="mt-4 flex items-center space-x-4 sm:mt-0">
                    <button class="btn btn-primary">
                        {{ __('admin.updatedetails') }}
                    </button>
                </div>
            </div>
            @method('PUT')
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">

                <div class="flex flex-col col-span-2">
                    @include('shared/select', ['name' => 'product_id', 'label' => __('global.product'), 'value' => old('product_id', $item->product_id), 'options' => $products])
                </div>
                <div class="flex flex-col col-span-2">
                    @include('shared/select', ['name' => 'type', 'label' => __('global.type'), 'value' => old('type', $item->type), 'options' => $types])
                </div>

                <div class="flex flex-col col-span-2">
                    @include('shared/select', ['name' => 'force', 'label' => __($translatePrefix . '.force_label'), 'value' => old('force', $item->product->hasMetadata('basket_url') ? 'yes' : 'no'), 'options' => $force])
                </div>
                <div class="flex flex-col col-span-2">
                    @include('shared/input', ['name' => 'max_services', 'label' => __($translatePrefix . '.max_services'), 'value' => old('max_services', $item->max_services), 'help' => __($translatePrefix . '.help')])
                </div>

                <div class="flex flex-col col-span-2">
                    @include('shared/input', ['name' => 'trial_days', 'label' => __($translatePrefix . '.trial_days'), 'value' => old('trial_days', $item->trial_days)])
                </div>

                <div class="flex flex-col col-span-2">
                    @include('shared/input', ['name' => 'max_allowed_services', 'label' => __($translatePrefix . '.max_allowed_services'), 'value' => old('max_allowed_services', $item->max_allowed_services), 'help' => __($translatePrefix . '.help')])
                </div>
                <div class="flex flex-col col-span-2">
                    @include('shared/input', ['name' => 'current_allowed_services', 'label' => __($translatePrefix . '.current_allowed_services'), 'value' => old('current_allowed_services', $item->current_allowed_services)])

                </div>
                <input type="hidden" name="id" value="{{ $item->id }}">

            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-5">
                {{ __($translatePrefix . '.show.table_title') }}
            <div class="border rounded-lg overflow-hidden dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>

                    <tr>

                        <th scope="col" class="px-6 py-3 text-start">
                            <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      #
                    </span>
                            </div>
                        </th>

                        <th scope="col" class="px-6 py-3 text-start">
                            <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __('global.service') }}
                    </span>
                            </div>
                        </th>

                        <th scope="col" class="px-6 py-3 text-start">
                            <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __($translatePrefix . '.show.successfully') }}
                    </span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-start">
                            <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                      {{ __('global.created') }}
                    </span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-start">
                                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">

                                        {{ __('global.actions') }}
                                                            </span>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @if (count($services) == 0)
                        <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex flex-auto flex-col justify-center items-center p-2 md:p-3">
                                    <p class="text-sm text-gray-800 dark:text-gray-400">
                                        {{ __('global.no_results') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @foreach($services as $item)

                        <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">

                            <td class="h-px w-px whitespace-nowrap">
                    <span class="block px-6 py-2">
                      <span class="text-sm text-gray-600 dark:text-gray-400">{{ $item->id }}</span>
                    </span>
                            </td>
                            <td class="h-px w-px whitespace-nowrap">
                    <span class="block px-6 py-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            <a href="{{ route('admin.services.show', ['service' => $item]) }}">
                                {{ $item->name }}
                            </a>
                        </span>
                    </span>
                            </td>

                            <td class="h-px w-px whitespace-nowrap px-6">
                                <x-badge-state state="{{ $item->hasMetadata('free_trial_paid') ? 'yes' : 'no' }}"></x-badge-state>
                            </td>


                            <td class="h-px w-px whitespace-nowrap">
                                                        <span class="block px-6 py-2">
                      <span class="text-sm text-gray-600 dark:text-gray-400">{{ $item->created_at != null ? $item->created_at->format('d/m/y') : 'None' }}</span>
                    </span>
                            </td>
                            <td class="h-px w-px whitespace-nowrap">

                                <a href="{{ route('admin.services.show', ['service' => $item]) }}">
                                        <span class="px-1 py-1.5">
                                          <span class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                                              <i class="bi bi-eye-fill"></i>
                                            {{ __('global.show') }}
                                          </span>
                                        </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
@endsection
