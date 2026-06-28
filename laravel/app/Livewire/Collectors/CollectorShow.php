<?php

namespace App\Livewire\Collectors;

use App\Models\Collector;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CollectorShow extends Component
{
    use AuthorizesRequests;

    public Collector $collector;

    public function mount(Collector $collector): void
    {
        $this->authorize('view', $collector);

        $this->collector = $collector;
    }

    public function render()
    {
        return view('livewire.collectors.collector-show')
            ->layout('layouts.app');
    }
}
