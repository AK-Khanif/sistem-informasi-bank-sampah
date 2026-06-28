<?php

namespace Tests\Unit\Services;

use App\Models\WasteCategory;
use App\Models\WasteType;
use App\Services\WasteTypeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class WasteTypeServiceTest extends TestCase
{
    use RefreshDatabase;

    private WasteTypeService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(WasteTypeService::class);
    }

    public function test_store_creates_waste_type(): void
    {
        $category = WasteCategory::factory()->create();

        $type = $this->service->store([
            'waste_category_id' => $category->id,
            'code' => 'BPET',
            'name' => 'Botol PET',
            'unit' => 'kg',
        ]);

        $this->assertDatabaseHas('waste_types', [
            'id' => $type->id,
            'code' => 'BPET',
            'name' => 'Botol PET',
        ]);
    }

    public function test_update_changes_specified_fields(): void
    {
        $type = WasteType::factory()->create([
            'name' => 'Jenis Lama',
            'unit' => 'kg',
        ]);

        $this->service->update($type->id, [
            'name' => 'Jenis Baru',
        ]);

        $updated = WasteType::find($type->id);

        $this->assertEquals('Jenis Baru', $updated->name);
        $this->assertEquals('kg', $updated->unit);
    }

    public function test_delete_soft_deletes(): void
    {
        $type = WasteType::factory()->create();

        $this->service->delete($type->id);

        $this->assertSoftDeleted('waste_types', [
            'id' => $type->id,
        ]);
    }

    public function test_find_by_id_throws_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->findById('non-existent-id');
    }

    public function test_get_paginated_returns_paginated_result(): void
    {
        $category = WasteCategory::factory()->create();
        WasteType::factory()->count(15)->create(['waste_category_id' => $category->id]);

        $result = $this->service->getPaginated();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(15, $result->total());
    }

    public function test_get_paginated_filters_by_search(): void
    {
        $category = WasteCategory::factory()->create();
        WasteType::factory()->create(['code' => 'BPET', 'name' => 'Botol PET', 'waste_category_id' => $category->id]);
        WasteType::factory()->create(['code' => 'KRT', 'name' => 'Kertas', 'waste_category_id' => $category->id]);

        $result = $this->service->getPaginated(['search' => 'Botol']);

        $this->assertEquals(1, $result->total());
        $this->assertEquals('Botol PET', $result->first()->name);
    }
}
