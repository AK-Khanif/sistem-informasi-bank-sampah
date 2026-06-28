<?php

namespace App\Livewire\WasteTypes;

use App\Models\WasteCategory;
use App\Models\WasteType;
use App\Services\WasteTypeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class WasteTypeEdit extends Component
{
    use AuthorizesRequests;

    public WasteType $wasteType;
    public string $waste_category_id = '';
    public string $code = '';
    public string $name = '';
    public string $unit = '';
    public ?string $description = null;
    public bool $is_active = true;

    private WasteTypeService $wasteTypeService;

    public function boot(WasteTypeService $wasteTypeService): void
    {
        $this->wasteTypeService = $wasteTypeService;
    }

    public function mount(WasteType $wasteType): void
    {
        $this->authorize('update', $wasteType);

        $this->wasteType = $wasteType;
        $this->waste_category_id = $wasteType->waste_category_id;
        $this->code = $wasteType->code;
        $this->name = $wasteType->name;
        $this->unit = $wasteType->unit;
        $this->description = $wasteType->description;
        $this->is_active = $wasteType->is_active;
    }

    public function rules(): array
    {
        return [
            'waste_category_id' => 'required|exists:waste_categories,id',
            'code' => 'required|string|max:10|unique:waste_types,code,' . $this->wasteType->id,
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('waste_types', 'name')
                    ->ignore($this->wasteType->id)
                    ->where('waste_category_id', $this->waste_category_id),
            ],
            'unit' => 'required|string|max:20',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $this->authorize('update', $this->wasteType);

        $this->validate();

        $this->wasteTypeService->update($this->wasteType->id, [
            'waste_category_id' => $this->waste_category_id,
            'code' => $this->code,
            'name' => $this->name,
            'unit' => $this->unit,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Data jenis sampah berhasil diperbarui.');

        $this->redirectRoute('waste-types.index', navigate: true);
    }

    public function render()
    {
        $categories = WasteCategory::select('id', 'name')
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        return view('livewire.waste-types.waste-type-edit', [
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
