<?php

namespace App\Addons\Freetrial\Models;

use App\Models\Store\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property int $trial_days
 * @property int $max_services
 * @property string $type
 * @property bool $show_on_card
 * @property int $max_renewals
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $trials
 * @property int|null $current_allowed_services
 * @property int|null $max_allowed_services
 * @property-read Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereCurrentAllowedServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereMaxAllowedServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereMaxRenewals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereMaxServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereTrialDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereTrials($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FreetrialConfig whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FreetrialConfig extends Model
{
    protected $table = 'freetrial_config';

    protected $fillable = [
        'product_id',
        'trial_days',
        'max_services',
        'type',
        'show_on_card',
        'current_allowed_services',
        'max_allowed_services',
        'trials',
    ];

    protected $attributes = [
        'max_services' => 1,
        'type' => 'trial',
        'show_on_card' => true,
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
