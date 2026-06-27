<?php

namespace App\Livewire\WasteCategories;

use App\Models\WasteCategory;
use App\Services\WasteCategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class WasteCategoryIndex extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $search = '';

    private WasteCategoryService $wasteCategoryService;

    public function boot(WasteCategoryService $wasteCategoryService): void
    {
        $this->wasteCategoryService = $wasteCategoryService;
    }

    public function mount(): void
    {
        $this->authorize('viewAny', WasteCategory::class);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(string $id): void
    {
        $category = $this->wasteCategoryService->findById($id);

        $this->authorize('delete', $category);

        try {
            $this->wasteCategoryService->delete($id);
            session()->flash('message', 'Data kategori berhasil dihapus.');
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $categories = $this->wasteCategoryService->getPaginated([
            'search' => $this->search,
        ]);

        return view('livewire.waste-categories.waste-category-index', [
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
