<?php

namespace App\Livewire\Collectors;

use App\Models\Collector;
use App\Services\CollectorService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CollectorEdit extends Component
{
    use AuthorizesRequests;

    public Collector $collector;
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

    public function mount(Collector $collector): void
    {
        $this->authorize('update', $collector);

        $this->collector = $collector;
        $this->name = $collector->name;
        $this->email = $collector->email;
        $this->phone = $collector->phone;
        $this->address = $collector->address;
        $this->contact_person = $collector->contact_person;
        $this->is_active = $collector->is_active;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150|unique:collectors,name,' . $this->collector->id,
            'email' => 'nullable|email|max:150|unique:collectors,email,' . $this->collector->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $this->authorize('update', $this->collector);

        $this->validate();

        $this->collectorService->update($this->collector->id, [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'contact_person' => $this->contact_person,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Data pengepul berhasil diperbarui.');

        $this->redirectRoute('collectors.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.collectors.collector-edit')
            ->layout('layouts.app');
    }
}
