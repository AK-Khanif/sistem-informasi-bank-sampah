<?php

namespace App\Livewire\WasteCategories;

use App\Models\WasteCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class WasteCategoryShow extends Component
{
    use AuthorizesRequests;

    public WasteCategory $wasteCategory;
    public int $wasteTypesCount = 0;

    public function mount(WasteCategory $wasteCategory): void
    {
        $this->authorize('view', $wasteCategory);

        $this->wasteCategory = $wasteCategory;
    }

    public function render()
    {
        return view('livewire.waste-categories.waste-category-show')
            ->layout('layouts.app');
    }
}
