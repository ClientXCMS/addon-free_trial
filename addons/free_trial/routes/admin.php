<?php

Route::resource('free_trial', \App\Addons\Freetrial\Controllers\Admin\FreetrialController::class)->except(['edit']);
