<?php

namespace App\Livewire\WasteTypes;

use App\Models\WasteType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class WasteTypeShow extends Component
{
    use AuthorizesRequests;

    public WasteType $wasteType;

    public function mount(WasteType $wasteType): void
    {
        $this->authorize('view', $wasteType);

        $this->wasteType = $wasteType->load('wasteCategory:id,name');
    }

    public function render()
    {
        return view('livewire.waste-types.waste-type-show')
            ->layout('layouts.app');
    }
}
