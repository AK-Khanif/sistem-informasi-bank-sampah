<?php

namespace App\Models;

use Database\Factories\WastePriceFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WastePrice extends Model
{
    /** @use HasFactory<WastePriceFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'waste_type_id',
        'buy_price',
        'effective_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'buy_price' => 'decimal:2',
            'effective_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function wasteType(): BelongsTo
    {
        return $this->belongsTo(WasteType::class)->withTrashed();
    }
}
