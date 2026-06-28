<?php

namespace App\Livewire\WastePrices;

use App\Models\WastePrice;
use App\Models\WasteType;
use App\Services\WastePriceService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class WastePriceEdit extends Component
{
    use AuthorizesRequests;

    public WastePrice $wastePrice;
    public string $waste_type_id = '';
    public string $buy_price = '';
    public string $effective_date = '';
    public bool $is_active = true;

    private WastePriceService $wastePriceService;

    public function boot(WastePriceService $wastePriceService): void
    {
        $this->wastePriceService = $wastePriceService;
    }

    public function mount(WastePrice $wastePrice): void
    {
        $this->authorize('update', $wastePrice);

        $this->wastePrice = $wastePrice->load('wasteType:id,code,name');
        $this->waste_type_id = $wastePrice->waste_type_id;
        $this->buy_price = $wastePrice->buy_price;
        $this->effective_date = $wastePrice->effective_date->format('Y-m-d');
        $this->is_active = $wastePrice->is_active;
    }

    public function rules(): array
    {
        return [
            'effective_date' => 'required|date',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $this->authorize('update', $this->wastePrice);

        $this->validate();

        $this->wastePriceService->update($this->wastePrice->id, [
            'effective_date' => $this->effective_date,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Data harga berhasil diperbarui.');

        $this->redirectRoute('waste-prices.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.waste-prices.waste-price-edit')
            ->layout('layouts.app');
    }
}
