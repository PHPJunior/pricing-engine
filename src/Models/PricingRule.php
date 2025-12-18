<?php

namespace PhpJunior\PricingEngine\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PricingRule extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('pricing-engine.table_names.pricing_rules');
    }

    protected $fillable = [
        'id',
        'name',
        'priority',
        'conditions',
        'actions'
    ];

    protected $casts = [
        'conditions' => 'array',
        'actions' => 'array',
    ];

    /**
     * @return HasMany
     */
    public function ruleUsages(): HasMany
    {
        return $this->hasMany(config('pricing-engine.models.rule_usage'), 'pricing_rule_id');
    }
}
