<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class CustomerEdit extends Component
{
    use AuthorizesRequests;

    public Customer $customer;
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

    public function mount(Customer $customer): void
    {
        $this->authorize('update', $customer);

        $this->customer = $customer;
        $this->full_name = $customer->full_name;
        $this->nik = $customer->nik;
        $this->gender = $customer->gender;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
        $this->notes = $customer->notes;
        $this->is_active = $customer->is_active;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:150',
            'nik' => 'nullable|string|max:20|unique:customers,nik,' . $this->customer->id,
            'gender' => 'nullable|string|in:L,P',
            'phone' => 'nullable|string|max:20|unique:customers,phone,' . $this->customer->id,
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }

    public function save(): void
    {
        $this->authorize('update', $this->customer);

        $this->validate();

        $this->customerService->update($this->customer->id, [
            'full_name' => $this->full_name,
            'nik' => $this->nik,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Data nasabah berhasil diperbarui.');

        $this->redirectRoute('customers.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.customers.customer-edit')
            ->layout('layouts.app');
    }
}
