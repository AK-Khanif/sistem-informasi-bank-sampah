<?php

namespace Tests\Feature\WasteTypes;

use App\Livewire\WasteTypes\WasteTypeCreate;
use App\Livewire\WasteTypes\WasteTypeEdit;
use App\Livewire\WasteTypes\WasteTypeIndex;
use App\Livewire\WasteTypes\WasteTypeShow;
use App\Models\User;
use App\Models\WasteCategory;
use App\Models\WasteType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class WasteTypeTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'view waste-types']);
        Permission::create(['name' => 'create waste-types']);
        Permission::create(['name' => 'update waste-types']);
        Permission::create(['name' => 'delete waste-types']);

        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo(
            'view waste-types',
            'create waste-types',
            'update waste-types',
            'delete waste-types'
        );
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('waste-types.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_without_permission_cannot_view_waste_types(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('waste-types.index'));

        $response->assertForbidden();
    }

    public function test_user_with_view_permission_can_view_waste_types(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(WasteTypeIndex::class)
            ->assertOk()
            ->assertSee('Jenis Sampah')
            ->assertSee('Tambah Jenis Sampah');
    }

    public function test_user_with_view_permission_can_view_detail(): void
    {
        $category = WasteCategory::factory()->create();
        $type = WasteType::factory()->create(['waste_category_id' => $category->id]);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeShow::class, ['wasteType' => $type])
            ->assertOk()
            ->assertSee($type->name)
            ->assertSee($type->code)
            ->assertSee($category->name);
    }

    public function test_user_without_create_permission_cannot_see_create_button(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view waste-types');

        $this->actingAs($user);

        Livewire::test(WasteTypeIndex::class)
            ->assertDontSee('Tambah Jenis Sampah');
    }

    public function test_user_without_create_permission_cannot_view_create_page(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view waste-types');

        $this->actingAs($user);

        $response = $this->get(route('waste-types.create'));

        $response->assertForbidden();
    }

    public function test_user_with_create_permission_can_create_waste_type(): void
    {
        $category = WasteCategory::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeCreate::class)
            ->set('waste_category_id', $category->id)
            ->set('code', 'BPET')
            ->set('name', 'Botol PET')
            ->set('unit', 'kg')
            ->call('save');

        $this->assertDatabaseHas('waste_types', [
            'code' => 'BPET',
            'name' => 'Botol PET',
            'waste_category_id' => $category->id,
        ]);
    }

    public function test_user_without_update_permission_cannot_edit(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view waste-types');
        $type = WasteType::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('waste-types.edit', $type));

        $response->assertForbidden();
    }

    public function test_user_with_update_permission_can_update(): void
    {
        $type = WasteType::factory()->create(['name' => 'Jenis Lama']);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeEdit::class, ['wasteType' => $type])
            ->set('name', 'Jenis Baru')
            ->call('save');

        $this->assertDatabaseHas('waste_types', [
            'id' => $type->id,
            'name' => 'Jenis Baru',
        ]);
    }

    public function test_user_with_delete_permission_can_delete(): void
    {
        $type = WasteType::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeIndex::class)
            ->call('delete', $type->id);

        $this->assertSoftDeleted('waste_types', [
            'id' => $type->id,
        ]);
    }

    public function test_waste_category_id_is_required(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(WasteTypeCreate::class)
            ->set('waste_category_id', '')
            ->set('code', 'BPET')
            ->set('name', 'Botol PET')
            ->set('unit', 'kg')
            ->call('save')
            ->assertHasErrors('waste_category_id');
    }

    public function test_code_is_required(): void
    {
        $category = WasteCategory::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeCreate::class)
            ->set('waste_category_id', $category->id)
            ->set('code', '')
            ->set('name', 'Botol PET')
            ->set('unit', 'kg')
            ->call('save')
            ->assertHasErrors('code');
    }

    public function test_code_must_be_unique(): void
    {
        $category = WasteCategory::factory()->create();
        WasteType::factory()->create(['code' => 'BPET', 'waste_category_id' => $category->id]);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeCreate::class)
            ->set('waste_category_id', $category->id)
            ->set('code', 'BPET')
            ->set('name', 'Botol PET')
            ->set('unit', 'kg')
            ->call('save')
            ->assertHasErrors('code');
    }

    public function test_name_is_required(): void
    {
        $category = WasteCategory::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeCreate::class)
            ->set('waste_category_id', $category->id)
            ->set('code', 'BPET')
            ->set('name', '')
            ->set('unit', 'kg')
            ->call('save')
            ->assertHasErrors('name');
    }

    public function test_name_must_be_unique_within_category(): void
    {
        $category = WasteCategory::factory()->create();
        WasteType::factory()->create(['name' => 'Botol PET', 'waste_category_id' => $category->id]);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeCreate::class)
            ->set('waste_category_id', $category->id)
            ->set('code', 'BPET2')
            ->set('name', 'Botol PET')
            ->set('unit', 'kg')
            ->call('save')
            ->assertHasErrors('name');
    }

    public function test_name_can_be_duplicated_across_different_categories(): void
    {
        $category1 = WasteCategory::factory()->create();
        $category2 = WasteCategory::factory()->create();
        WasteType::factory()->create(['name' => 'Campuran', 'waste_category_id' => $category1->id]);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeCreate::class)
            ->set('waste_category_id', $category2->id)
            ->set('code', 'CMP2')
            ->set('name', 'Campuran')
            ->set('unit', 'kg')
            ->call('save');

        $this->assertDatabaseHas('waste_types', [
            'code' => 'CMP2',
            'name' => 'Campuran',
            'waste_category_id' => $category2->id,
        ]);
    }

    public function test_unit_is_required(): void
    {
        $category = WasteCategory::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeCreate::class)
            ->set('waste_category_id', $category->id)
            ->set('code', 'BPET')
            ->set('name', 'Botol PET')
            ->set('unit', '')
            ->call('save')
            ->assertHasErrors('unit');
    }

    public function test_search_by_code_returns_filtered_results(): void
    {
        $category = WasteCategory::factory()->create();
        WasteType::factory()->create(['code' => 'BPET', 'name' => 'Botol PET', 'waste_category_id' => $category->id]);
        WasteType::factory()->create(['code' => 'KRT', 'name' => 'Kertas HVS', 'waste_category_id' => $category->id]);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeIndex::class)
            ->set('search', 'BPET')
            ->assertSee('Botol PET')
            ->assertDontSee('Kertas HVS');
    }

    public function test_search_by_name_returns_filtered_results(): void
    {
        $category = WasteCategory::factory()->create();
        WasteType::factory()->create(['code' => 'BPET', 'name' => 'Botol PET', 'waste_category_id' => $category->id]);
        WasteType::factory()->create(['code' => 'KRT', 'name' => 'Kertas HVS', 'waste_category_id' => $category->id]);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeIndex::class)
            ->set('search', 'Kertas HVS')
            ->assertSee('Kertas HVS')
            ->assertDontSee('Botol PET');
    }

    public function test_filter_by_category_returns_filtered_results(): void
    {
        $category1 = WasteCategory::factory()->create(['name' => 'Plastik']);
        $category2 = WasteCategory::factory()->create(['name' => 'Kertas']);
        WasteType::factory()->create(['code' => 'BPET', 'name' => 'Botol PET', 'waste_category_id' => $category1->id]);
        WasteType::factory()->create(['code' => 'KRT', 'name' => 'Koran Bekas', 'waste_category_id' => $category2->id]);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeIndex::class)
            ->set('wasteCategoryId', $category1->id)
            ->assertSee('Botol PET')
            ->assertDontSee('Koran Bekas');
    }

    public function test_soft_deleted_waste_type_not_shown_in_index(): void
    {
        $type = WasteType::factory()->create(['name' => 'Akan Dihapus']);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeIndex::class)
            ->call('delete', $type->id)
            ->assertDontSee('Akan Dihapus');
    }

    public function test_edit_code_unique_excludes_own_record(): void
    {
        $type = WasteType::factory()->create(['code' => 'BPET']);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeEdit::class, ['wasteType' => $type])
            ->set('code', 'BPET')
            ->set('name', 'Botol PET Updated')
            ->call('save')
            ->assertHasNoErrors('code');
    }

    public function test_edit_name_unique_excludes_own_record_in_same_category(): void
    {
        $category = WasteCategory::factory()->create();
        $type = WasteType::factory()->create([
            'name' => 'Botol PET',
            'waste_category_id' => $category->id,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(WasteTypeEdit::class, ['wasteType' => $type])
            ->set('waste_category_id', $category->id)
            ->set('code', 'BPET')
            ->set('name', 'Botol PET')
            ->call('save')
            ->assertHasNoErrors('name');
    }
}
