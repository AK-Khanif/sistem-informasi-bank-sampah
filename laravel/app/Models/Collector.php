<?php

namespace App\Models;

use Database\Factories\CollectorFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collector extends Model
{
    /** @use HasFactory<CollectorFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'collector_code',
        'name',
        'email',
        'phone',
        'address',
        'contact_person',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
