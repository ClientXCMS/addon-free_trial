<?php

Route::get('free_trial/{product}', [\App\Addons\Freetrial\Controllers\Front\FreetrialController::class, 'config'])->name('config');
Route::post('free_trial/{product}', [\App\Addons\Freetrial\Controllers\Front\FreetrialController::class, 'process']);
