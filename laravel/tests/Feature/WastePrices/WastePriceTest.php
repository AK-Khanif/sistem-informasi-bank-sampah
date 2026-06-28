<?php

namespace Tests\Feature\WastePrices;

use App\Livewire\WastePrices\WastePriceCreate;
use App\Livewire\WastePrices\WastePriceEdit;
use App\Livewire\WastePrices\WastePriceIndex;
use App\Livewire\WastePrices\WastePriceShow;
use App\Models\User;
use App\Models\WasteType;
use App\Models\WastePrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class WastePriceTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'view waste-prices']);
        Permission::create(['name' => 'create waste-prices']);
        Permission::create(['name' => 'update waste-prices']);
        Permission::create(['name' => 'delete waste-prices']);

        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo(
            'view waste-prices',
            'create waste-prices',
            'update waste-prices',
            'delete waste-prices'
        );
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('waste-prices.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_without_permission_cannot_view_prices(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('waste-prices.index'));

        $response->assertForbidden();
    }

    public function test_user_with_view_permission_can_view_prices(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(WastePriceIndex::class)
            ->assertOk()
            ->assertSee('Harga Sampah')
            ->assertSee('Tambah Harga');
    }

    public function test_user_with_view_permission_can_view_detail(): void
    {
        $type = WasteType::factory()->create();
        $price = WastePrice::factory()->create(['waste_type_id' => $type->id]);

        $this->actingAs($this->admin);

        Livewire::test(WastePriceShow::class, ['wastePrice' => $price])
            ->assertOk()
            ->assertSee($type->code)
            ->assertSee($type->name);
    }

    public function test_user_without_create_permission_cannot_see_create_button(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view waste-prices');

        $this->actingAs($user);

        Livewire::test(WastePriceIndex::class)
            ->assertDontSee('Tambah Harga');
    }

    public function test_user_without_create_permission_cannot_view_create_page(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view waste-prices');

        $this->actingAs($user);

        $response = $this->get(route('waste-prices.create'));

        $response->assertForbidden();
    }

    public function test_user_with_create_permission_can_create_price(): void
    {
        $type = WasteType::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', $type->id)
            ->set('buy_price', '5000')
            ->set('effective_date', '2026-07-01')
            ->call('save');

        $this->assertDatabaseHas('waste_prices', [
            'waste_type_id' => $type->id,
            'buy_price' => 5000,
            'effective_date' => '2026-07-01 00:00:00',
            'is_active' => 1,
        ]);
    }

    public function test_creating_active_price_deactivates_others_for_same_waste_type(): void
    {
        $type = WasteType::factory()->create();
        $oldPrice = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => true,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', $type->id)
            ->set('buy_price', '10000')
            ->set('effective_date', '2026-08-01')
            ->call('save');

        $this->assertDatabaseHas('waste_prices', [
            'id' => $oldPrice->id,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('waste_prices', [
            'waste_type_id' => $type->id,
            'buy_price' => 10000.00,
            'is_active' => true,
        ]);
    }

    public function test_creating_inactive_price_does_not_affect_active_prices(): void
    {
        $type = WasteType::factory()->create();
        $activePrice = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => true,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', $type->id)
            ->set('buy_price', '10000')
            ->set('effective_date', '2026-08-01')
            ->set('is_active', false)
            ->call('save');

        $this->assertDatabaseHas('waste_prices', [
            'id' => $activePrice->id,
            'is_active' => true,
        ]);
    }

    public function test_creating_active_price_does_not_affect_other_waste_types(): void
    {
        $type1 = WasteType::factory()->create();
        $type2 = WasteType::factory()->create();
        $otherPrice = WastePrice::factory()->create([
            'waste_type_id' => $type2->id,
            'is_active' => true,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', $type1->id)
            ->set('buy_price', '5000')
            ->set('effective_date', '2026-07-01')
            ->call('save');

        $this->assertDatabaseHas('waste_prices', [
            'id' => $otherPrice->id,
            'is_active' => true,
        ]);
    }

    public function test_user_without_update_permission_cannot_edit(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view waste-prices');
        $price = WastePrice::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('waste-prices.edit', $price));

        $response->assertForbidden();
    }

    public function test_user_with_update_permission_can_update_effective_date(): void
    {
        $type = WasteType::factory()->create();
        $price = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'effective_date' => '2026-01-01',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(WastePriceEdit::class, ['wastePrice' => $price])
            ->set('effective_date', '2026-06-15')
            ->call('save');

        $this->assertDatabaseHas('waste_prices', [
            'id' => $price->id,
            'effective_date' => '2026-06-15 00:00:00',
        ]);
    }

    public function test_activating_price_via_update_deactivates_others(): void
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

        $this->actingAs($this->admin);

        Livewire::test(WastePriceEdit::class, ['wastePrice' => $inactivePrice])
            ->set('is_active', true)
            ->call('save');

        $this->assertDatabaseHas('waste_prices', [
            'id' => $activePrice->id,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('waste_prices', [
            'id' => $inactivePrice->id,
            'is_active' => true,
        ]);
    }

    public function test_deactivating_active_price_does_not_activate_others(): void
    {
        $type = WasteType::factory()->create();
        $price = WastePrice::factory()->create([
            'waste_type_id' => $type->id,
            'is_active' => true,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(WastePriceEdit::class, ['wastePrice' => $price])
            ->set('is_active', false)
            ->call('save');

        $this->assertDatabaseHas('waste_prices', [
            'id' => $price->id,
            'is_active' => false,
        ]);
    }

    public function test_user_with_delete_permission_can_delete(): void
    {
        $price = WastePrice::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WastePriceIndex::class)
            ->call('delete', $price->id);

        $this->assertSoftDeleted('waste_prices', [
            'id' => $price->id,
        ]);
    }

    public function test_waste_type_id_is_required(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', '')
            ->set('buy_price', '5000')
            ->set('effective_date', '2026-07-01')
            ->call('save')
            ->assertHasErrors('waste_type_id');
    }

    public function test_buy_price_is_required(): void
    {
        $type = WasteType::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', $type->id)
            ->set('buy_price', '')
            ->set('effective_date', '2026-07-01')
            ->call('save')
            ->assertHasErrors('buy_price');
    }

    public function test_buy_price_must_be_numeric(): void
    {
        $type = WasteType::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', $type->id)
            ->set('buy_price', 'abc')
            ->set('effective_date', '2026-07-01')
            ->call('save')
            ->assertHasErrors('buy_price');
    }

    public function test_buy_price_must_be_positive(): void
    {
        $type = WasteType::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', $type->id)
            ->set('buy_price', '-100')
            ->set('effective_date', '2026-07-01')
            ->call('save')
            ->assertHasErrors('buy_price');
    }

    public function test_effective_date_is_required(): void
    {
        $type = WasteType::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', $type->id)
            ->set('buy_price', '5000')
            ->set('effective_date', '')
            ->call('save')
            ->assertHasErrors('effective_date');
    }

    public function test_effective_date_must_be_valid_date(): void
    {
        $type = WasteType::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WastePriceCreate::class)
            ->set('waste_type_id', $type->id)
            ->set('buy_price', '5000')
            ->set('effective_date', 'not-a-date')
            ->call('save')
            ->assertHasErrors('effective_date');
    }

    public function test_search_by_waste_type_name_returns_filtered_results(): void
    {
        $type1 = WasteType::factory()->create(['code' => 'BPET', 'name' => 'Botol PET']);
        $type2 = WasteType::factory()->create(['code' => 'KRT', 'name' => 'Kertas HVS']);
        WastePrice::factory()->create(['waste_type_id' => $type1->id, 'buy_price' => 5000]);
        WastePrice::factory()->create(['waste_type_id' => $type2->id, 'buy_price' => 10000]);

        $this->actingAs($this->admin);

        Livewire::test(WastePriceIndex::class)
            ->set('search', 'Botol')
            ->assertSee('5.000')
            ->assertDontSee('10.000');
    }

    public function test_filter_by_waste_type_returns_filtered_results(): void
    {
        $type1 = WasteType::factory()->create(['code' => 'BPET', 'name' => 'Botol PET']);
        $type2 = WasteType::factory()->create(['code' => 'KRT', 'name' => 'Kertas HVS']);
        WastePrice::factory()->create(['waste_type_id' => $type1->id, 'buy_price' => 5000]);
        WastePrice::factory()->create(['waste_type_id' => $type2->id, 'buy_price' => 10000]);

        $this->actingAs($this->admin);

        Livewire::test(WastePriceIndex::class)
            ->set('wasteTypeId', $type1->id)
            ->assertSee('5.000')
            ->assertDontSee('10.000');
    }

    public function test_filter_by_active_status_returns_filtered_results(): void
    {
        $type = WasteType::factory()->create();
        WastePrice::factory()->create(['waste_type_id' => $type->id, 'is_active' => true, 'buy_price' => 5000]);
        WastePrice::factory()->create(['waste_type_id' => $type->id, 'is_active' => false, 'buy_price' => 6000]);

        $this->actingAs($this->admin);

        Livewire::test(WastePriceIndex::class)
            ->set('isActiveFilter', '1')
            ->assertSee('5.000')
            ->assertDontSee('6.000');
    }

    public function test_soft_deleted_price_not_shown_in_index(): void
    {
        $price = WastePrice::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WastePriceIndex::class)
            ->call('delete', $price->id)
            ->assertDontSee($price->buy_price);
    }
}
