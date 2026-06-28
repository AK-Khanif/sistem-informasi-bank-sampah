<?php

namespace App\Livewire\WastePrices;

use App\Models\WastePrice;
use App\Models\WasteType;
use App\Services\WastePriceService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class WastePriceIndex extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $search = '';
    public string $wasteTypeId = '';
    public string $isActiveFilter = '';

    private WastePriceService $wastePriceService;

    public function boot(WastePriceService $wastePriceService): void
    {
        $this->wastePriceService = $wastePriceService;
    }

    public function mount(): void
    {
        $this->authorize('viewAny', WastePrice::class);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingWasteTypeId(): void
    {
        $this->resetPage();
    }

    public function updatingIsActiveFilter(): void
    {
        $this->resetPage();
    }

    public function delete(string $id): void
    {
        $price = $this->wastePriceService->findById($id);

        $this->authorize('delete', $price);

        try {
            $this->wastePriceService->delete($id);
            session()->flash('message', 'Data harga berhasil dihapus.');
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $prices = $this->wastePriceService->getPaginated([
            'search' => $this->search,
            'waste_type_id' => $this->wasteTypeId,
            'is_active' => $this->isActiveFilter,
        ]);

        $wasteTypes = WasteType::select('id', 'code', 'name')
            ->orderBy('code')
            ->get();

        return view('livewire.waste-prices.waste-price-index', [
            'prices' => $prices,
            'wasteTypes' => $wasteTypes,
        ])->layout('layouts.app');
    }
}
