<?php

namespace App\Livewire\WasteCategories;

use App\Models\WasteCategory;
use App\Services\WasteCategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class WasteCategoryCreate extends Component
{
    use AuthorizesRequests;

    public string $code = '';
    public string $name = '';
    public ?string $description = null;
    public bool $is_active = true;

    private WasteCategoryService $wasteCategoryService;

    public function boot(WasteCategoryService $wasteCategoryService): void
    {
        $this->wasteCategoryService = $wasteCategoryService;
    }

    public function mount(): void
    {
        $this->authorize('create', WasteCategory::class);
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:10|unique:waste_categories,code',
            'name' => 'required|string|max:100|unique:waste_categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $this->authorize('create', WasteCategory::class);

        $this->validate();

        $this->wasteCategoryService->store([
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Data kategori berhasil disimpan.');

        $this->redirectRoute('waste-categories.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.waste-categories.waste-category-create')
            ->layout('layouts.app');
    }
}
