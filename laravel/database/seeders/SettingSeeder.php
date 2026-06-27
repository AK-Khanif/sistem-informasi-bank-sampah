<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'rw_name' => 'RW 05',
            'rw_address' => 'Kelurahan Wates, Kecamatan Ngaliyan, Kota Semarang',
            'rw_phone' => null,
            'bank_sampah_name' => 'Bank Sampah RW 05',
            'deposit_prefix' => 'DEP',
            'sale_prefix' => 'SAL',
            'customer_prefix' => 'NSB',
            'backup_enabled' => false,
            'backup_retention_days' => 30,
        ]);
    }
}
