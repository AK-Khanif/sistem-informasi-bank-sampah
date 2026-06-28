<?php

namespace App\Livewire\WastePrices;

use App\Models\WastePrice;
use App\Models\WasteType;
use App\Services\WastePriceService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class WastePriceCreate extends Component
{
    use AuthorizesRequests;

    public string $waste_type_id = '';
    public string $buy_price = '';
    public string $effective_date = '';
    public bool $is_active = true;

    private WastePriceService $wastePriceService;

    public function boot(WastePriceService $wastePriceService): void
    {
        $this->wastePriceService = $wastePriceService;
    }

    public function mount(): void
    {
        $this->authorize('create', WastePrice::class);
    }

    public function rules(): array
    {
        return [
            'waste_type_id' => 'required|exists:waste_types,id',
            'buy_price' => 'required|numeric|min:0|max:999999999999',
            'effective_date' => 'required|date',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $this->authorize('create', WastePrice::class);

        $this->validate();

        $this->wastePriceService->store([
            'waste_type_id' => $this->waste_type_id,
            'buy_price' => $this->buy_price,
            'effective_date' => $this->effective_date,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Data harga berhasil disimpan.');

        $this->redirectRoute('waste-prices.index', navigate: true);
    }

    public function render()
    {
        $wasteTypes = WasteType::select('id', 'code', 'name')
            ->orderBy('code')
            ->get();

        return view('livewire.waste-prices.waste-price-create', [
            'wasteTypes' => $wasteTypes,
        ])->layout('layouts.app');
    }
}
