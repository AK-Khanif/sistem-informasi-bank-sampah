<?php

namespace App\Livewire\Collectors;

use App\Models\Collector;
use App\Services\CollectorService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class CollectorIndex extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $search = '';

    private CollectorService $collectorService;

    public function boot(CollectorService $collectorService): void
    {
        $this->collectorService = $collectorService;
    }

    public function mount(): void
    {
        $this->authorize('viewAny', Collector::class);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(string $id): void
    {
        $collector = $this->collectorService->findById($id);

        $this->authorize('delete', $collector);

        $this->collectorService->delete($id);

        session()->flash('message', 'Data pengepul berhasil dihapus.');
    }

    public function render()
    {
        $collectors = $this->collectorService->getPaginated([
            'search' => $this->search,
        ]);

        return view('livewire.collectors.collector-index', [
            'collectors' => $collectors,
        ])->layout('layouts.app');
    }
}
