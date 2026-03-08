<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QualityCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_order_id',
        'checked_at',
        'moisture_percentage',
        'fat_content_percentage',
        'particle_size_microns',
        'temperature',
        'viscosity',
        'ph_value',
        'passed',
        'notes',
        'checked_by',
    ];

    protected function casts(): array
    {
        return [
            'checked_at' => 'datetime',
            'passed' => 'boolean',
            'moisture_percentage' => 'decimal:2',
            'fat_content_percentage' => 'decimal:2',
            'particle_size_microns' => 'decimal:2',
            'temperature' => 'decimal:2',
            'viscosity' => 'decimal:2',
            'ph_value' => 'decimal:2',
        ];
    }

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function checker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
