<?php

namespace App\Livewire\WastePrices;

use App\Models\WastePrice;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class WastePriceShow extends Component
{
    use AuthorizesRequests;

    public WastePrice $wastePrice;
    public $priceHistory;

    public function mount(WastePrice $wastePrice): void
    {
        $this->authorize('view', $wastePrice);

        $this->wastePrice = $wastePrice->load('wasteType.wasteCategory:id,name');

        $this->priceHistory = WastePrice::query()
            ->where('waste_type_id', $wastePrice->waste_type_id)
            ->where('id', '!=', $wastePrice->id)
            ->orderBy('effective_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.waste-prices.waste-price-show')
            ->layout('layouts.app');
    }
}
