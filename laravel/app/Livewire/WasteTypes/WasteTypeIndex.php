<?php

namespace App\Livewire\WasteTypes;

use App\Models\WasteCategory;
use App\Models\WasteType;
use App\Services\WasteTypeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class WasteTypeIndex extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $search = '';
    public string $wasteCategoryId = '';

    private WasteTypeService $wasteTypeService;

    public function boot(WasteTypeService $wasteTypeService): void
    {
        $this->wasteTypeService = $wasteTypeService;
    }

    public function mount(): void
    {
        $this->authorize('viewAny', WasteType::class);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingWasteCategoryId(): void
    {
        $this->resetPage();
    }

    public function delete(string $id): void
    {
        $wasteType = $this->wasteTypeService->findById($id);

        $this->authorize('delete', $wasteType);

        try {
            $this->wasteTypeService->delete($id);
            session()->flash('message', 'Data jenis sampah berhasil dihapus.');
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $types = $this->wasteTypeService->getPaginated([
            'search' => $this->search,
            'waste_category_id' => $this->wasteCategoryId,
        ]);

        $categories = WasteCategory::select('id', 'name')
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        return view('livewire.waste-types.waste-type-index', [
            'types' => $types,
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
