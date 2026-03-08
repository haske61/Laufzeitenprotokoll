<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'type',
        'status',
        'bean_delivery_id',
        'batch_number',
        'target_quantity_kg',
        'actual_quantity_kg',
        'yield_percentage',
        'planned_start',
        'planned_end',
        'actual_start',
        'actual_end',
        'operator_name',
        'shift',
        'notes',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'planned_start' => 'datetime',
            'planned_end' => 'datetime',
            'actual_start' => 'datetime',
            'actual_end' => 'datetime',
            'target_quantity_kg' => 'decimal:2',
            'actual_quantity_kg' => 'decimal:2',
            'yield_percentage' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function beanDelivery(): BelongsTo
    {
        return $this->belongsTo(BeanDelivery::class);
    }

    public function productionLogs(): HasMany
    {
        return $this->hasMany(ProductionLog::class);
    }

    public function qualityChecks(): HasMany
    {
        return $this->hasMany(QualityCheck::class);
    }

    public function scopeNibs(Builder $query): Builder
    {
        return $query->where('type', 'nibs');
    }

    public function scopeMass(Builder $query): Builder
    {
        return $query->where('type', 'mass');
    }

    public function calculateYield(): ?float
    {
        if (!$this->target_quantity_kg || $this->target_quantity_kg == 0) {
            return null;
        }

        return ($this->actual_quantity_kg / $this->target_quantity_kg) * 100;
    }
}
