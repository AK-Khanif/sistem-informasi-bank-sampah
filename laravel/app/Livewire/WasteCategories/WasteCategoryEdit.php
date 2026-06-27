<?php

namespace App\Livewire\WasteCategories;

use App\Models\WasteCategory;
use App\Services\WasteCategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class WasteCategoryEdit extends Component
{
    use AuthorizesRequests;

    public WasteCategory $wasteCategory;
    public string $code = '';
    public string $name = '';
    public ?string $description = null;
    public bool $is_active = true;

    private WasteCategoryService $wasteCategoryService;

    public function boot(WasteCategoryService $wasteCategoryService): void
    {
        $this->wasteCategoryService = $wasteCategoryService;
    }

    public function mount(WasteCategory $wasteCategory): void
    {
        $this->authorize('update', $wasteCategory);

        $this->wasteCategory = $wasteCategory;
        $this->code = $wasteCategory->code;
        $this->name = $wasteCategory->name;
        $this->description = $wasteCategory->description;
        $this->is_active = $wasteCategory->is_active;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:10|unique:waste_categories,code,' . $this->wasteCategory->id,
            'name' => 'required|string|max:100|unique:waste_categories,name,' . $this->wasteCategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $this->authorize('update', $this->wasteCategory);

        $this->validate();

        $this->wasteCategoryService->update($this->wasteCategory->id, [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Data kategori berhasil diperbarui.');

        $this->redirectRoute('waste-categories.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.waste-categories.waste-category-edit')
            ->layout('layouts.app');
    }
}
