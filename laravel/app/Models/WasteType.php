<?php

namespace App\Models;

use Database\Factories\WasteTypeFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WasteType extends Model
{
    /** @use HasFactory<WasteTypeFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'waste_category_id',
        'code',
        'name',
        'unit',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function wasteCategory(): BelongsTo
    {
        return $this->belongsTo(WasteCategory::class);
    }
}
