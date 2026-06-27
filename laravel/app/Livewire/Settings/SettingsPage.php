<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SettingsPage extends Component
{
    use AuthorizesRequests;

    public string $rw_name = '';
    public ?string $rw_address = null;
    public ?string $rw_phone = null;
    public string $bank_sampah_name = '';
    public string $deposit_prefix = '';
    public string $sale_prefix = '';
    public string $customer_prefix = '';
    public bool $backup_enabled = false;
    public int $backup_retention_days = 30;

    private SettingService $settingService;

    public function boot(SettingService $settingService): void
    {
        $this->settingService = $settingService;
    }

    public function mount(): void
    {
        $this->authorize('view', Setting::class);

        $settings = $this->settingService->getSettings();

        $this->rw_name = $settings->rw_name;
        $this->rw_address = $settings->rw_address;
        $this->rw_phone = $settings->rw_phone;
        $this->bank_sampah_name = $settings->bank_sampah_name;
        $this->deposit_prefix = $settings->deposit_prefix;
        $this->sale_prefix = $settings->sale_prefix;
        $this->customer_prefix = $settings->customer_prefix;
        $this->backup_enabled = $settings->backup_enabled;
        $this->backup_retention_days = $settings->backup_retention_days;
    }

    public function rules(): array
    {
        return [
            'rw_name' => 'required|string|max:100',
            'rw_address' => 'nullable|string',
            'rw_phone' => 'nullable|string|max:20',
            'bank_sampah_name' => 'required|string|max:150',
            'deposit_prefix' => 'required|string|max:10',
            'sale_prefix' => 'required|string|max:10',
            'customer_prefix' => 'required|string|max:10',
            'backup_enabled' => 'boolean',
            'backup_retention_days' => 'required|integer|min:1|max:365',
        ];
    }

    public function save(): void
    {
        $this->authorize('update', Setting::class);

        $this->validate();

        $this->settingService->updateSettings($this->validate());

        session()->flash('message', 'Pengaturan berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.settings.settings-page')
            ->layout('layouts.app');
    }
}
