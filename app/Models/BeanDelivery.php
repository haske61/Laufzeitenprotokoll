<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BeanDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_name',
        'origin_country',
        'bean_type',
        'batch_number',
        'delivery_date',
        'quantity_kg',
        'moisture_percentage',
        'fat_content_percentage',
        'quality_grade',
        'unit_price',
        'notes',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'delivery_date' => 'date',
            'quantity_kg' => 'decimal:2',
            'moisture_percentage' => 'decimal:2',
            'fat_content_percentage' => 'decimal:2',
            'unit_price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productionOrders(): HasMany
    {
        return $this->hasMany(ProductionOrder::class);
    }
}
