<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        return [
            'rw_name' => 'RW 05',
            'rw_address' => 'Kelurahan Wates, Kecamatan Ngaliyan, Kota Semarang',
            'rw_phone' => null,
            'bank_sampah_name' => 'Bank Sampah RW 05',
            'deposit_prefix' => 'DEP',
            'sale_prefix' => 'SAL',
            'customer_prefix' => 'NSB',
            'backup_enabled' => false,
            'backup_retention_days' => 30,
        ];
    }
}
