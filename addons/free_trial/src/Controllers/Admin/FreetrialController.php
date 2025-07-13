<?php

namespace App\Addons\Freetrial\Controllers\Admin;

use App\Addons\Freetrial\Models\FreetrialConfig;
use App\Addons\Freetrial\Requests\FreetrialRequest;
use App\Core\Admin\Dashboard\AdminCountWidget;
use App\Http\Controllers\Admin\AbstractCrudController;
use App\Models\Provisioning\Service;
use App\Models\Store\Product;

class FreetrialController extends AbstractCrudController
{
    protected string $model = \App\Addons\Freetrial\Models\FreetrialConfig::class;

    protected string $viewPath = 'free_trial_admin::config/';

    protected string $routePath = 'admin.free_trial';

    protected string $translatePrefix = 'free_trial::lang.admin.config';

    public function store(FreetrialRequest $request)
    {
        $trial = $request->store();

        return $this->storeRedirect($trial);
    }

    public function getIndexParams($items, string $translatePrefix)
    {
        $params = parent::getIndexParams($items, $translatePrefix);
        $widgets = collect();
        $current_trials = FreetrialConfig::sum('current_allowed_services');
        $trials_done = FreetrialConfig::sum('trials');
        $trials_success = Service::getItemsByMetadata('free_trial_paid', 'true')->count();
        $widgets->push(new AdminCountWidget('current_trials', 'bi bi-boxes', $this->translatePrefix.'.current_trials', $current_trials, true));
        $widgets->push(new AdminCountWidget('trials_done', 'bi bi-check2-circle', $this->translatePrefix.'.trials_done', $trials_done, true));
        $widgets->push(new AdminCountWidget('trials_success', 'bi bi-patch-check', $this->translatePrefix.'.trials_success', $trials_success, true));
        $params['widgets'] = $widgets;

        return $params;
    }

    public function getCreateParams()
    {
        $params = parent::getCreateParams();
        $params['products'] = Product::all()->pluck('name', 'id');
        $params['types'] = __($this->translatePrefix.'.types');
        $params['force'] = __($this->translatePrefix.'.force');

        return $params;
    }

    public function show(FreetrialConfig $free_trial)
    {
        $params['products'] = Product::all()->pluck('name', 'id');
        $params['types'] = __($this->translatePrefix.'.types');
        $params['item'] = $free_trial;
        $params['force'] = __($this->translatePrefix.'.force');
        $params['services'] = Service::getItemsByMetadata('free_trial_config', $free_trial->id);

        return $this->showView($params);
    }

    public function update(FreetrialRequest $request, FreetrialConfig $free_trial)
    {
        $request->update();
        return $this->updateRedirect($free_trial);
    }

    public function destroy(FreetrialConfig $free_trial)
    {
        $free_trial->delete();
        return $this->destroyRedirect();
    }
}
