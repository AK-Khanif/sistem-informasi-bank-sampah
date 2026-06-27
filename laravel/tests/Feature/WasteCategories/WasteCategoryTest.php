<?php

namespace Tests\Feature\WasteCategories;

use App\Livewire\WasteCategories\WasteCategoryCreate;
use App\Livewire\WasteCategories\WasteCategoryEdit;
use App\Livewire\WasteCategories\WasteCategoryIndex;
use App\Livewire\WasteCategories\WasteCategoryShow;
use App\Models\User;
use App\Models\WasteCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class WasteCategoryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'view waste-categories']);
        Permission::create(['name' => 'create waste-categories']);
        Permission::create(['name' => 'update waste-categories']);
        Permission::create(['name' => 'delete waste-categories']);

        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo(
            'view waste-categories',
            'create waste-categories',
            'update waste-categories',
            'delete waste-categories'
        );
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('waste-categories.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_without_permission_cannot_view_categories(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('waste-categories.index'));

        $response->assertForbidden();
    }

    public function test_user_with_view_permission_can_view_categories(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryIndex::class)
            ->assertOk()
            ->assertSee('Kategori Sampah')
            ->assertSee('Tambah Kategori');
    }

    public function test_user_with_view_permission_can_view_detail(): void
    {
        $category = WasteCategory::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryShow::class, ['wasteCategory' => $category])
            ->assertOk()
            ->assertSee($category->name)
            ->assertSee($category->code);
    }

    public function test_user_without_create_permission_cannot_see_create_button(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view waste-categories');

        $this->actingAs($user);

        Livewire::test(WasteCategoryIndex::class)
            ->assertDontSee('Tambah Kategori');
    }

    public function test_user_without_create_permission_cannot_view_create_page(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view waste-categories');

        $this->actingAs($user);

        $response = $this->get(route('waste-categories.create'));

        $response->assertForbidden();
    }

    public function test_user_with_create_permission_can_create_category(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryCreate::class)
            ->set('code', 'PLA')
            ->set('name', 'Plastik')
            ->set('description', 'Kategori sampah plastik')
            ->call('save');

        $this->assertDatabaseHas('waste_categories', [
            'code' => 'PLA',
            'name' => 'Plastik',
        ]);
    }

    public function test_user_without_update_permission_cannot_edit_category(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view waste-categories');
        $category = WasteCategory::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('waste-categories.edit', $category));

        $response->assertForbidden();
    }

    public function test_user_with_update_permission_can_update_category(): void
    {
        $category = WasteCategory::factory()->create([
            'name' => 'Kategori Lama',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryEdit::class, ['wasteCategory' => $category])
            ->set('name', 'Kategori Baru')
            ->call('save');

        $this->assertDatabaseHas('waste_categories', [
            'id' => $category->id,
            'name' => 'Kategori Baru',
        ]);
    }

    public function test_user_with_delete_permission_can_delete_category(): void
    {
        $category = WasteCategory::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryIndex::class)
            ->call('delete', $category->id);

        $this->assertSoftDeleted('waste_categories', [
            'id' => $category->id,
        ]);
    }

    public function test_code_is_required(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryCreate::class)
            ->set('code', '')
            ->set('name', 'Plastik')
            ->call('save')
            ->assertHasErrors('code');
    }

    public function test_name_is_required(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryCreate::class)
            ->set('code', 'PLA')
            ->set('name', '')
            ->call('save')
            ->assertHasErrors('name');
    }

    public function test_code_must_be_unique(): void
    {
        WasteCategory::factory()->create(['code' => 'PLA']);

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryCreate::class)
            ->set('code', 'PLA')
            ->set('name', 'Plastik')
            ->call('save')
            ->assertHasErrors('code');
    }

    public function test_name_must_be_unique(): void
    {
        WasteCategory::factory()->create(['name' => 'Plastik']);

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryCreate::class)
            ->set('code', 'KRT')
            ->set('name', 'Plastik')
            ->call('save')
            ->assertHasErrors('name');
    }

    public function test_search_by_code_returns_filtered_results(): void
    {
        WasteCategory::factory()->create(['code' => 'PLA', 'name' => 'Plastik']);
        WasteCategory::factory()->create(['code' => 'KRT', 'name' => 'Kertas']);

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryIndex::class)
            ->set('search', 'PLA')
            ->assertSee('Plastik')
            ->assertDontSee('Kertas');
    }

    public function test_search_by_name_returns_filtered_results(): void
    {
        WasteCategory::factory()->create(['code' => 'PLA', 'name' => 'Plastik']);
        WasteCategory::factory()->create(['code' => 'KRT', 'name' => 'Kertas']);

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryIndex::class)
            ->set('search', 'Kertas')
            ->assertSee('Kertas')
            ->assertDontSee('Plastik');
    }

    public function test_soft_deleted_category_not_shown_in_index(): void
    {
        $category = WasteCategory::factory()->create(['name' => 'Akan Dihapus']);

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryIndex::class)
            ->call('delete', $category->id)
            ->assertDontSee('Akan Dihapus');
    }

    public function test_edit_code_unique_excludes_own_record(): void
    {
        $category = WasteCategory::factory()->create([
            'code' => 'PLA',
            'name' => 'Plastik',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryEdit::class, ['wasteCategory' => $category])
            ->set('code', 'PLA')
            ->set('name', 'Plastik Updated')
            ->call('save')
            ->assertHasNoErrors('code');
    }

    public function test_edit_name_unique_excludes_own_record(): void
    {
        $category = WasteCategory::factory()->create([
            'code' => 'PLA',
            'name' => 'Plastik',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(WasteCategoryEdit::class, ['wasteCategory' => $category])
            ->set('code', 'PLA')
            ->set('name', 'Plastik')
            ->call('save')
            ->assertHasNoErrors('name');
    }
}
