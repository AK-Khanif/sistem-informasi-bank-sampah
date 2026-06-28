<?php

namespace Tests\Feature\Collectors;

use App\Livewire\Collectors\CollectorCreate;
use App\Livewire\Collectors\CollectorEdit;
use App\Livewire\Collectors\CollectorIndex;
use App\Livewire\Collectors\CollectorShow;
use App\Models\Collector;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CollectorTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'view collectors']);
        Permission::create(['name' => 'create collectors']);
        Permission::create(['name' => 'update collectors']);
        Permission::create(['name' => 'delete collectors']);

        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo('view collectors', 'create collectors', 'update collectors', 'delete collectors');
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('collectors.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_without_permission_cannot_view_collectors(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('collectors.index'));

        $response->assertForbidden();
    }

    public function test_user_with_view_permission_can_view_collectors(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CollectorIndex::class)
            ->assertOk()
            ->assertSee('Daftar Pengepul')
            ->assertSee('Tambah Pengepul');
    }

    public function test_user_with_view_permission_can_view_collector_detail(): void
    {
        $collector = Collector::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(CollectorShow::class, ['collector' => $collector])
            ->assertOk()
            ->assertSee($collector->name)
            ->assertSee($collector->collector_code);
    }

    public function test_user_without_create_permission_cannot_see_create_button(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view collectors');

        $this->actingAs($user);

        Livewire::test(CollectorIndex::class)
            ->assertDontSee('Tambah Pengepul');
    }

    public function test_user_without_create_permission_cannot_view_create_page(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view collectors');

        $this->actingAs($user);

        $response = $this->get(route('collectors.create'));

        $response->assertForbidden();
    }

    public function test_user_with_create_permission_can_create_collector(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CollectorCreate::class)
            ->set('name', 'PT Budi Jaya')
            ->set('phone', '08123456789')
            ->set('address', 'Jl. Merdeka No. 1')
            ->call('save');

        $this->assertDatabaseHas('collectors', [
            'name' => 'PT Budi Jaya',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
        ]);
    }

    public function test_collector_code_is_auto_generated(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CollectorCreate::class)
            ->set('name', 'PT Maju Bersama')
            ->call('save');

        $collector = Collector::where('name', 'PT Maju Bersama')->first();

        $this->assertNotNull($collector);
        $this->assertMatchesRegularExpression('/^PNG-\d{6}$/', $collector->collector_code);
    }

    public function test_user_without_update_permission_cannot_edit_collector(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view collectors');
        $collector = Collector::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('collectors.edit', $collector));

        $response->assertForbidden();
    }

    public function test_user_with_update_permission_can_update_collector(): void
    {
        $collector = Collector::factory()->create([
            'name' => 'Nama Lama',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(CollectorEdit::class, ['collector' => $collector])
            ->set('name', 'Nama Baru')
            ->call('save');

        $this->assertDatabaseHas('collectors', [
            'id' => $collector->id,
            'name' => 'Nama Baru',
        ]);
    }

    public function test_user_without_delete_permission_cannot_see_delete_button(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view collectors');
        $collector = Collector::factory()->create();

        $this->actingAs($user);

        Livewire::test(CollectorIndex::class)
            ->assertDontSee('Hapus');
    }

    public function test_user_with_delete_permission_can_delete_collector(): void
    {
        $collector = Collector::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(CollectorIndex::class)
            ->call('delete', $collector->id);

        $this->assertSoftDeleted('collectors', [
            'id' => $collector->id,
        ]);
    }

    public function test_name_is_required(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CollectorCreate::class)
            ->set('name', '')
            ->call('save')
            ->assertHasErrors('name');
    }

    public function test_name_must_be_unique(): void
    {
        Collector::factory()->create(['name' => 'PT Budi Jaya']);

        $this->actingAs($this->admin);

        Livewire::test(CollectorCreate::class)
            ->set('name', 'PT Budi Jaya')
            ->call('save')
            ->assertHasErrors('name');
    }

    public function test_email_must_be_unique(): void
    {
        Collector::factory()->create(['email' => 'budi@example.com']);

        $this->actingAs($this->admin);

        Livewire::test(CollectorCreate::class)
            ->set('name', 'PT Lain')
            ->set('email', 'budi@example.com')
            ->call('save')
            ->assertHasErrors('email');
    }

    public function test_search_by_name_returns_filtered_results(): void
    {
        Collector::factory()->create(['name' => 'PT Budi Jaya']);
        Collector::factory()->create(['name' => 'PT Siti Abadi']);

        $this->actingAs($this->admin);

        Livewire::test(CollectorIndex::class)
            ->set('search', 'Budi Jaya')
            ->assertSee('PT Budi Jaya')
            ->assertDontSee('PT Siti Abadi');
    }

    public function test_soft_deleted_collector_not_shown_in_index(): void
    {
        $collector = Collector::factory()->create(['name' => 'Akan Dihapus']);

        $this->actingAs($this->admin);

        Livewire::test(CollectorIndex::class)
            ->call('delete', $collector->id)
            ->assertDontSee('Akan Dihapus');
    }

    public function test_edit_name_unique_excludes_own_record(): void
    {
        $collector = Collector::factory()->create([
            'name' => 'Test User',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(CollectorEdit::class, ['collector' => $collector])
            ->set('name', 'Test User')
            ->call('save')
            ->assertHasNoErrors('name');
    }

    public function test_edit_email_unique_excludes_own_record(): void
    {
        $collector = Collector::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(CollectorEdit::class, ['collector' => $collector])
            ->set('email', 'test@example.com')
            ->call('save')
            ->assertHasNoErrors('email');
    }
}
