<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerIndex extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $search = '';

    private CustomerService $customerService;

    public function boot(CustomerService $customerService): void
    {
        $this->customerService = $customerService;
    }

    public function mount(): void
    {
        $this->authorize('viewAny', Customer::class);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(string $id): void
    {
        $customer = $this->customerService->findById($id);

        $this->authorize('delete', $customer);

        $this->customerService->delete($id);

        session()->flash('message', 'Data nasabah berhasil dihapus.');
    }

    public function render()
    {
        $customers = $this->customerService->getPaginated([
            'search' => $this->search,
        ]);

        return view('livewire.customers.customer-index', [
            'customers' => $customers,
        ])->layout('layouts.app');
    }
}
