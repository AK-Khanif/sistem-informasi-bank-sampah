<?php

namespace Tests\Unit\Services;

use App\Models\WasteCategory;
use App\Services\WasteCategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class WasteCategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private WasteCategoryService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(WasteCategoryService::class);
    }

    public function test_store_creates_category(): void
    {
        $category = $this->service->store([
            'code' => 'PLA',
            'name' => 'Plastik',
        ]);

        $this->assertDatabaseHas('waste_categories', [
            'id' => $category->id,
            'code' => 'PLA',
            'name' => 'Plastik',
        ]);
    }

    public function test_update_changes_specified_fields(): void
    {
        $category = WasteCategory::factory()->create([
            'name' => 'Kategori Lama',
            'description' => 'Deskripsi Lama',
        ]);

        $this->service->update($category->id, [
            'name' => 'Kategori Baru',
        ]);

        $updated = WasteCategory::find($category->id);

        $this->assertEquals('Kategori Baru', $updated->name);
        $this->assertEquals('Deskripsi Lama', $updated->description);
    }

    public function test_delete_soft_deletes_category(): void
    {
        $category = WasteCategory::factory()->create();

        $this->service->delete($category->id);

        $this->assertSoftDeleted('waste_categories', [
            'id' => $category->id,
        ]);
    }

    public function test_find_by_id_throws_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->findById('non-existent-id');
    }

    public function test_get_paginated_returns_paginated_result(): void
    {
        WasteCategory::factory()->count(15)->create();

        $result = $this->service->getPaginated();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(15, $result->total());
    }

    public function test_get_paginated_filters_by_search(): void
    {
        WasteCategory::factory()->create(['code' => 'PLA', 'name' => 'Plastik']);
        WasteCategory::factory()->create(['code' => 'KRT', 'name' => 'Kertas']);

        $result = $this->service->getPaginated(['search' => 'Plastik']);

        $this->assertEquals(1, $result->total());
        $this->assertEquals('Plastik', $result->first()->name);
    }

}
