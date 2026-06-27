<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CustomerCreate extends Component
{
    use AuthorizesRequests;

    public string $full_name = '';
    public ?string $nik = null;
    public ?string $gender = null;
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $notes = null;
    public bool $is_active = true;

    private CustomerService $customerService;

    public function boot(CustomerService $customerService): void
    {
        $this->customerService = $customerService;
    }

    public function mount(): void
    {
        $this->authorize('create', Customer::class);
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:150',
            'nik' => 'nullable|string|max:20|unique:customers,nik',
            'gender' => 'nullable|string|in:L,P',
            'phone' => 'nullable|string|max:20|unique:customers,phone',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $this->authorize('create', Customer::class);

        $this->validate();

        $this->customerService->store([
            'full_name' => $this->full_name,
            'nik' => $this->nik,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Data nasabah berhasil disimpan.');

        $this->redirectRoute('customers.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.customers.customer-create')
            ->layout('layouts.app');
    }
}
