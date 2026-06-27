<?php

namespace Tests\Unit\Services;

use App\Models\Customer;
use App\Services\CustomerService;
use Database\Seeders\SettingSeeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CustomerServiceTest extends TestCase
{
    use RefreshDatabase;

    private CustomerService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SettingSeeder::class);

        $this->service = app(CustomerService::class);
    }

    public function test_generate_customer_code_uses_settings_prefix(): void
    {
        $code = $this->service->generateCustomerCode();

        $this->assertStringStartsWith('NSB-', $code);
    }

    public function test_generate_customer_code_increments_sequence(): void
    {
        $firstCode = $this->service->generateCustomerCode();
        Customer::factory()->create(['customer_code' => $firstCode]);

        $secondCode = $this->service->generateCustomerCode();

        $this->assertEquals('NSB-000002', $secondCode);
    }

    public function test_store_creates_customer_with_auto_code(): void
    {
        $customer = $this->service->store([
            'full_name' => 'Budi Santoso',
            'gender' => 'L',
        ]);

        $this->assertNotNull($customer->customer_code);
        $this->assertStringStartsWith('NSB-', $customer->customer_code);
        $this->assertEquals('Budi Santoso', $customer->full_name);
    }

    public function test_update_changes_specified_fields(): void
    {
        $customer = Customer::factory()->create([
            'full_name' => 'Nama Lama',
            'address' => 'Alamat Lama',
        ]);

        $this->service->update($customer->id, [
            'full_name' => 'Nama Baru',
        ]);

        $updated = Customer::find($customer->id);

        $this->assertEquals('Nama Baru', $updated->full_name);
        $this->assertEquals('Alamat Lama', $updated->address);
    }

    public function test_delete_soft_deletes_customer(): void
    {
        $customer = Customer::factory()->create();

        $this->service->delete($customer->id);

        $this->assertSoftDeleted('customers', [
            'id' => $customer->id,
        ]);
    }

    public function test_find_by_id_throws_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->findById('non-existent-id');
    }

    public function test_get_paginated_returns_paginated_result(): void
    {
        Customer::factory()->count(15)->create();

        $result = $this->service->getPaginated();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(15, $result->total());
    }

    public function test_get_paginated_filters_by_search(): void
    {
        Customer::factory()->create(['full_name' => 'Budi Santoso']);
        Customer::factory()->create(['full_name' => 'Siti Aminah']);

        $result = $this->service->getPaginated(['search' => 'Budi']);

        $this->assertEquals(1, $result->total());
        $this->assertEquals('Budi Santoso', $result->first()->full_name);
    }
}
