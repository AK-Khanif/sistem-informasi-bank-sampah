<?php

namespace Tests\Unit\Services;

use App\Models\Collector;
use App\Services\CollectorService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CollectorServiceTest extends TestCase
{
    use RefreshDatabase;

    private CollectorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(CollectorService::class);
    }

    public function test_generate_collector_code_uses_png_prefix(): void
    {
        $code = $this->service->generateCollectorCode();

        $this->assertStringStartsWith('PNG-', $code);
    }

    public function test_generate_collector_code_increments_sequence(): void
    {
        $firstCode = $this->service->generateCollectorCode();
        Collector::factory()->create(['collector_code' => $firstCode]);

        $secondCode = $this->service->generateCollectorCode();

        $this->assertEquals('PNG-000002', $secondCode);
    }

    public function test_store_creates_collector_with_auto_code(): void
    {
        $collector = $this->service->store([
            'name' => 'PT Budi Jaya',
            'phone' => '08123456789',
        ]);

        $this->assertNotNull($collector->collector_code);
        $this->assertStringStartsWith('PNG-', $collector->collector_code);
        $this->assertEquals('PT Budi Jaya', $collector->name);
    }

    public function test_update_changes_specified_fields(): void
    {
        $collector = Collector::factory()->create([
            'name' => 'Nama Lama',
            'address' => 'Alamat Lama',
        ]);

        $this->service->update($collector->id, [
            'name' => 'Nama Baru',
        ]);

        $updated = Collector::find($collector->id);

        $this->assertEquals('Nama Baru', $updated->name);
        $this->assertEquals('Alamat Lama', $updated->address);
    }

    public function test_delete_soft_deletes_collector(): void
    {
        $collector = Collector::factory()->create();

        $this->service->delete($collector->id);

        $this->assertSoftDeleted('collectors', [
            'id' => $collector->id,
        ]);
    }

    public function test_find_by_id_throws_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->findById('non-existent-id');
    }

    public function test_get_paginated_returns_paginated_result(): void
    {
        Collector::factory()->count(15)->create();

        $result = $this->service->getPaginated();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(15, $result->total());
    }

    public function test_get_paginated_filters_by_search(): void
    {
        Collector::factory()->create(['name' => 'PT Budi Jaya']);
        Collector::factory()->create(['name' => 'PT Siti Abadi']);

        $result = $this->service->getPaginated(['search' => 'Budi']);

        $this->assertEquals(1, $result->total());
        $this->assertEquals('PT Budi Jaya', $result->first()->name);
    }
}
