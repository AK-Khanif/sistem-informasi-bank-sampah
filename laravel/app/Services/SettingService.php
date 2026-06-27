<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingService
{
    public function getSettings(): Setting
    {
        $settings = Setting::first();

        if (!$settings) {
            $settings = Setting::create([
                'rw_name' => 'RW 05',
                'rw_address' => null,
                'rw_phone' => null,
                'bank_sampah_name' => 'Bank Sampah',
                'deposit_prefix' => 'DEP',
                'sale_prefix' => 'SAL',
                'customer_prefix' => 'NSB',
                'backup_enabled' => false,
                'backup_retention_days' => 30,
            ]);
        }

        return $settings;
    }

    public function updateSettings(array $data): Setting
    {
        return DB::transaction(function () use ($data) {
            $settings = $this->getSettings();
            $settings->update($data);

            return $settings->fresh();
        });
    }
}
