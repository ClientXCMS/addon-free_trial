<?php

namespace App\Addons\Freetrial;

use App\Addons\Freetrial\Models\FreetrialConfig;
use App\Events\Core\Service\ServiceCancelled;
use App\Events\Core\Service\ServiceExpired;
use App\Events\Core\Service\ServiceRenewed;
use App\Events\Core\Service\ServiceUpgraded;
use App\Extensions\BaseAddonServiceProvider;
use App\Models\Admin\Permission;
use App\Models\Provisioning\Service;
use Illuminate\Support\Facades\Event;

class FreetrialServiceProvider extends BaseAddonServiceProvider
{
    protected string $uuid = 'free_trial';

    public function boot()
    {
        $this->loadTranslations();
        $this->loadViews();
        $this->loadMigrations();

        \Route::middleware('web')
            ->name($this->uuid.'.')
            ->group(function () {
                require addon_path($this->uuid, 'routes/web.php');
            });
        \Route::middleware(['web', 'admin'])
            ->prefix('admin')
            ->name('admin.')
            ->group(function () {
                require addon_path($this->uuid, 'routes/admin.php');
            });
        $settings = $this->app->make('settings');
        $settings->addCardItem('extensions', $this->uuid, $this->uuid.'::lang.admin.config.title', 'free_trial::lang.admin.config.subheading', 'bi bi-universal-access', action([\App\Addons\Freetrial\Controllers\Admin\FreetrialController::class, 'index']), Permission::MANAGE_EXTENSIONS);
        // Lors qu'un service est expiré, cela veut dire que la période d'essai est terminé et qu'on peut retirer l'essaie en cours dans les utilisés
        Event::listen(ServiceExpired::class, function (ServiceExpired $event) {
            $service = $event->service;
            if ($service->trial_ends_at == null) {
                return;
            }
            if ($service->hasMetadata('free_trial_config')) {
                $trial_config = $service->getMetadata('free_trial_config');
                $trial_config = FreetrialConfig::find($trial_config);
                if ($trial_config) {
                    $trial_config->decrement('current_allowed_services');
                }
            }
        });

        Event::listen(ServiceCancelled::class, function (ServiceCancelled $event) {
            $service = $event->service;
            if ($service->trial_ends_at == null) {
                return;
            }
            if ($service->hasMetadata('free_trial_config')) {
                $trial_config = $service->getMetadata('free_trial_config');
                $trial_config = FreetrialConfig::find($trial_config);
                if ($trial_config) {
                    $trial_config->decrement('current_allowed_services');
                    $service->attachMetadata('free_trial_paid', 'false');

                }
            }
        });
        // Lors qu'un service est renouvellé, cela veut dire que la période d'essai est terminé
        Event::listen(ServiceRenewed::class, function (ServiceRenewed $event) {
            $service = $event->service;
            if ($service->trial_end_at != null) {
                $service->update(['trial_ends_at' => null]);
                if ($service->hasMetadata('free_trial_config')) {
                    $trial_config = $service->getMetadata('free_trial_config');
                    $trial_config = FreetrialConfig::find($trial_config);
                    if ($trial_config) {
                        $trial_config->decrement('current_allowed_services');
                        $service->attachMetadata('free_trial_paid', 'true');
                    }
                }
            }
        });

        Event::listen(ServiceUpgraded::class, function (ServiceUpgraded $event) {
            $service = $event->service;
            if ($service->trial_ends_at != null) {
                $service->update(['trial_ends_at' => null]);
                if ($service->hasMetadata('free_trial_config')) {
                    $trial_config = $service->getMetadata('free_trial_config');
                    $trial_config = FreetrialConfig::find($trial_config);
                    if ($trial_config) {
                        $trial_config->decrement('current_allowed_services');
                        $service->attachMetadata('free_trial_paid', 'true');
                    }
                }
            }
        });
    }
}
