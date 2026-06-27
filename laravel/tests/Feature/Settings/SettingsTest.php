<?php

namespace Tests\Feature\Settings;

use App\Livewire\Settings\SettingsPage;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'view settings']);
        Permission::create(['name' => 'update settings']);

        $this->seed(SettingSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo('view settings', 'update settings');
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('settings.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_without_permission_cannot_view_settings(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings.index'));

        $response->assertForbidden();
    }

    public function test_user_with_permission_can_view_settings(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SettingsPage::class)
            ->assertOk()
            ->assertSee('Nama RW')
            ->assertSee('Nama Bank Sampah')
            ->assertSee('Simpan');
    }

    public function test_user_without_update_permission_cannot_update_settings(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view settings');

        $this->actingAs($user);

        Livewire::test(SettingsPage::class)
            ->call('save')
            ->assertForbidden();
    }

    public function test_admin_can_update_settings(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SettingsPage::class)
            ->set('rw_name', 'RW 10')
            ->set('rw_address', 'Alamat Baru')
            ->set('rw_phone', '08123456789')
            ->set('bank_sampah_name', 'Bank Sampah RW 10')
            ->set('backup_enabled', true)
            ->set('backup_retention_days', 60)
            ->call('save');

        $settings = Setting::first();

        $this->assertEquals('RW 10', $settings->rw_name);
        $this->assertEquals('Alamat Baru', $settings->rw_address);
        $this->assertEquals('08123456789', $settings->rw_phone);
        $this->assertEquals('Bank Sampah RW 10', $settings->bank_sampah_name);
        $this->assertTrue($settings->backup_enabled);
        $this->assertEquals(60, $settings->backup_retention_days);
    }

    public function test_rw_name_is_required(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SettingsPage::class)
            ->set('rw_name', '')
            ->call('save')
            ->assertHasErrors('rw_name');
    }

    public function test_backup_retention_days_minimum_is_1(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SettingsPage::class)
            ->set('backup_retention_days', 0)
            ->call('save')
            ->assertHasErrors('backup_retention_days');
    }

    public function test_backup_retention_days_maximum_is_365(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SettingsPage::class)
            ->set('backup_retention_days', 366)
            ->call('save')
            ->assertHasErrors('backup_retention_days');
    }
}
