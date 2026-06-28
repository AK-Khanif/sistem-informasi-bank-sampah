<?php

namespace App\Livewire\Collectors;

use App\Models\Collector;
use App\Services\CollectorService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CollectorCreate extends Component
{
    use AuthorizesRequests;

    public string $name = '';
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $contact_person = null;
    public bool $is_active = true;

    private CollectorService $collectorService;

    public function boot(CollectorService $collectorService): void
    {
        $this->collectorService = $collectorService;
    }

    public function mount(): void
    {
        $this->authorize('create', Collector::class);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150|unique:collectors,name',
            'email' => 'nullable|email|max:150|unique:collectors,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $this->authorize('create', Collector::class);

        $this->validate();

        $this->collectorService->store([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'contact_person' => $this->contact_person,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Data pengepul berhasil disimpan.');

        $this->redirectRoute('collectors.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.collectors.collector-create')
            ->layout('layouts.app');
    }
}
