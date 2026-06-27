<?php

namespace App\Models;

use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'rw_name',
        'rw_address',
        'rw_phone',
        'bank_sampah_name',
        'deposit_prefix',
        'sale_prefix',
        'customer_prefix',
        'backup_enabled',
        'backup_retention_days',
    ];

    protected function casts(): array
    {
        return [
            'backup_enabled' => 'boolean',
            'backup_retention_days' => 'integer',
        ];
    }
}
