<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    private SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? '';

        return Customer::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('customer_code', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function findById(string $id): Customer
    {
        return Customer::findOrFail($id);
    }

    public function store(array $data): Customer
    {
        return DB::transaction(function () use ($data) {
            $data['customer_code'] = $this->generateCustomerCode();

            return Customer::create($data);
        });
    }

    public function update(string $id, array $data): Customer
    {
        $customer = $this->findById($id);
        $customer->update($data);

        return $customer->fresh();
    }

    public function delete(string $id): void
    {
        $customer = $this->findById($id);
        $customer->delete();
    }

    public function generateCustomerCode(): string
    {
        $settings = $this->settingService->getSettings();
        $prefix = $settings->customer_prefix;

        $lastCustomer = Customer::withTrashed()
            ->where('customer_code', 'like', "{$prefix}-%")
            ->orderBy('customer_code', 'desc')
            ->lockForUpdate()
            ->first();

        if ($lastCustomer) {
            $lastNumber = (int) substr($lastCustomer->customer_code, strlen($prefix) + 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf('%s-%06d', $prefix, $newNumber);
    }
}
