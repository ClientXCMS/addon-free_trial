<?php
/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
?>
@extends('admin/layouts/admin')
@section('title',  __($translatePrefix . '.create.title'))
@section('content')

    <div class="max-w-[85rem] py-5 lg:py-7 mx-auto">
        <div class="mx-auto">
            @include('admin/shared/alerts')
                <form method="POST" class="card" action="{{ route($routePath . '.store') }}">
                    <div class="card-heading">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                {{ __($translatePrefix . '.create.title') }}
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __($translatePrefix. '.create.subheading') }}
                            </p>
                        </div>

                        <div class="mt-4 flex items-center space-x-4 sm:mt-0">
                            <button class="btn btn-primary">
                                {{ __('admin.create') }}
                            </button>
                        </div>
                    </div>
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="flex flex-col col-span-3">
                            @include('admin/shared/select', ['name' => 'product_id', 'label' => __('global.product'), 'value' => old('product_id', $item->product_id), 'options' => $products])
                        </div>
                        <div class="flex flex-col col-span-3">
                            @include('admin/shared/select', ['name' => 'type', 'label' => __('global.type'), 'value' => old('type', $item->type), 'options' => $types])
                        </div>

                        <div class="flex flex-col col-span-3">
                            @include('admin/shared/select', ['name' => 'force', 'label' => __($translatePrefix . '.force_label'), 'value' => old('force', 'no'), 'options' => $force])
                        </div>
                        <div class="flex flex-col col-span-2">
                            @include('admin/shared/input', ['name' => 'max_services', 'label' => __($translatePrefix . '.max_services'), 'value' => old('max_services', $item->max_services), 'help' => __($translatePrefix . '.help')])
                        </div>

                        <div class="flex flex-col col-span-2">
                            @include('admin/shared/input', ['name' => 'trial_days', 'label' => __($translatePrefix . '.trial_days'), 'value' => old('trial_days', $item->trial_days)])
                        </div>
                        <div class="flex flex-col col-span-2">
                            @include('admin/shared/input', ['name' => 'max_allowed_services', 'label' => __($translatePrefix . '.max_allowed_services'), 'value' => old('max_allowed_services', $item->max_allowed_services)])
                        </div>
                        <input type="hidden" name="id" value="{{ $item->id }}">
                    </div>
                </form>
    </div>

@endsection
