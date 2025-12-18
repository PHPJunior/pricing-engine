<?php

namespace PhpJunior\PricingEngine\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RuleUsage extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('pricing-engine.table_names.rule_usages');
    }

    protected $fillable = [
        'id',
        'pricing_rule_id',
        'discount_amount',
        'final_price',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];
}
