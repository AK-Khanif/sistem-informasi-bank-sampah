<?php

namespace Tests\Unit\Services;

use App\Models\WastePrice;
use App\Models\WasteType;
use App\Services\WastePriceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class WastePriceServiceTest extends TestCase
{
    use RefreshDatabase;

    private WastePriceService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(WastePriceService::class);
    }

    public function test_store_creates_price(): void
    {
        $type = WasteType::factory()->create();

        $price = $this->service->store([
            'waste_type_id' => $type->id,
            'buy_price' => 5000,
            'effective_date' => '2026-07-01',
        ]);

        $this->assertDatabaseHas('waste_prices', [
            'id' => $price->id,
            'waste_type_id' => $type->id,
            'buy_price' => 5000.00,
            'is_active' => true,
        ]);
    }

    public function test_store_active_deactivates_others(): void
    {
        $type = WasteType::factory()->create();
        $oldPrice = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => true,
        ]);

        $this->service->store([
            'waste_type_id' => $type->id,
            'buy_price' => 10000,
            'effective_date' => '2026-08-01',
        ]);

        $this->assertDatabaseHas('waste_prices', [
            'id' => $oldPrice->id,
            'is_active' => false,
        ]);
    }

    public function test_store_inactive_keeps_others_active(): void
    {
        $type = WasteType::factory()->create();
        $activePrice = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => true,
        ]);

        $this->service->store([
            'waste_type_id' => $type->id,
            'buy_price' => 10000,
            'effective_date' => '2026-08-01',
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('waste_prices', [
            'id' => $activePrice->id,
            'is_active' => true,
        ]);
    }

    public function test_update_effective_date_only(): void
    {
        $type = WasteType::factory()->create();
        $price = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'buy_price' => 5000,
            'effective_date' => '2026-01-01',
        ]);

        $this->service->update($price->id, [
            'effective_date' => '2026-06-15',
        ]);

        $updated = WastePrice::find($price->id);

        $this->assertEquals('2026-06-15', $updated->effective_date->format('Y-m-d'));
        $this->assertEquals(5000.00, $updated->buy_price);
    }

    public function test_update_activating_deactivates_others(): void
    {
        $type = WasteType::factory()->create();
        $activePrice = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => true,
        ]);
        $inactivePrice = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => false,
        ]);

        $this->service->update($inactivePrice->id, [
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('waste_prices', [
            'id' => $activePrice->id,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('waste_prices', [
            'id' => $inactivePrice->id,
            'is_active' => true,
        ]);
    }

    public function test_update_deactivating_keeps_others_unchanged(): void
    {
        $type = WasteType::factory()->create();
        $price = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => true,
        ]);

        $this->service->update($price->id, [
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('waste_prices', [
            'id' => $price->id,
            'is_active' => false,
        ]);
    }

    public function test_delete_soft_deletes(): void
    {
        $price = WastePrice::factory()->create();

        $this->service->delete($price->id);

        $this->assertSoftDeleted('waste_prices', [
            'id' => $price->id,
        ]);
    }

    public function test_find_by_id_throws_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->findById('non-existent-id');
    }

    public function test_get_paginated_returns_paginated_result(): void
    {
        WastePrice::factory()->count(15)->create();

        $result = $this->service->getPaginated();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(10, $result->perPage());
        $this->assertEquals(15, $result->total());
    }

    public function test_get_paginated_filters_by_search(): void
    {
        $type1 = WasteType::factory()->create(['name' => 'Botol PET']);
        $type2 = WasteType::factory()->create(['name' => 'Kertas HVS']);
        WastePrice::factory()->create(['waste_type_id' => $type1->id]);
        WastePrice::factory()->create(['waste_type_id' => $type2->id]);

        $result = $this->service->getPaginated(['search' => 'Botol']);

        $this->assertEquals(1, $result->total());
    }

    public function test_get_active_price_returns_active_price(): void
    {
        $type = WasteType::factory()->create();
        WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => true,
            'buy_price' => 5000,
        ]);

        $activePrice = $this->service->getActivePrice($type->id);

        $this->assertNotNull($activePrice);
        $this->assertEquals(5000.00, $activePrice->buy_price);
    }

    public function test_get_active_price_returns_null_when_none_active(): void
    {
        $type = WasteType::factory()->create();
        WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => false,
        ]);

        $activePrice = $this->service->getActivePrice($type->id);

        $this->assertNull($activePrice);
    }

    public function test_get_active_price_returns_latest_active(): void
    {
        $type = WasteType::factory()->create();
        WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => false,
            'buy_price' => 3000,
            'effective_date' => '2026-01-01',
        ]);
        WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => true,
            'buy_price' => 5000,
            'effective_date' => '2026-06-01',
        ]);

        $activePrice = $this->service->getActivePrice($type->id);

        $this->assertNotNull($activePrice);
        $this->assertEquals(5000.00, $activePrice->buy_price);
    }
}
