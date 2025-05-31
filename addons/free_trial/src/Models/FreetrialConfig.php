<?php

namespace App\Addons\Freetrial\Models;

use App\Models\Store\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FreetrialConfig extends Model
{
    protected $table = 'freetrial_config';

    protected $fillable = [
        'product_id',
        'trial_days',
        'max_services',
        'type',
        'current_allowed_services',
        'max_allowed_services',
        'trials',
    ];

    protected $attributes = [
        'max_services' => 1,
        'type' => 'trial',
        'trial_days' => 7,
        'max_allowed_services' => 10,
        'current_allowed_services' => 0,
        'trials' => 0,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function startDate()
    {
        return Carbon::now();
    }

    public function endDate()
    {
        return Carbon::now()->addDays($this->trial_days);
    }
}
