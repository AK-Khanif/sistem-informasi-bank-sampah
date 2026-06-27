<?php

namespace Tests\Unit\Services;

use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingServiceTest extends TestCase
{
    use RefreshDatabase;

    private SettingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(SettingService::class);
    }

    public function test_get_settings_creates_default_row_when_table_is_empty(): void
    {
        $this->assertNull(Setting::first());

        $settings = $this->service->getSettings();

        $this->assertNotNull($settings);
        $this->assertEquals('RW 05', $settings->rw_name);
        $this->assertEquals('Bank Sampah', $settings->bank_sampah_name);
        $this->assertFalse($settings->backup_enabled);
        $this->assertEquals(30, $settings->backup_retention_days);
    }

    public function test_get_settings_returns_existing_row(): void
    {
        Setting::factory()->create([
            'rw_name' => 'RW 10',
        ]);

        $settings = $this->service->getSettings();

        $this->assertEquals('RW 10', $settings->rw_name);
        $this->assertCount(1, Setting::all());
    }

    public function test_update_settings_updates_data(): void
    {
        Setting::factory()->create();

        $this->service->updateSettings([
            'rw_name' => 'RW 20',
            'backup_retention_days' => 90,
        ]);

        $settings = Setting::first();

        $this->assertEquals('RW 20', $settings->rw_name);
        $this->assertEquals(90, $settings->backup_retention_days);
    }

    public function test_update_settings_only_changes_specified_fields(): void
    {
        Setting::factory()->create([
            'rw_name' => 'RW Awal',
            'bank_sampah_name' => 'Bank Sampah Asli',
        ]);

        $this->service->updateSettings([
            'rw_name' => 'RW Baru',
        ]);

        $settings = Setting::first();

        $this->assertEquals('RW Baru', $settings->rw_name);
        $this->assertEquals('Bank Sampah Asli', $settings->bank_sampah_name);
    }
}
