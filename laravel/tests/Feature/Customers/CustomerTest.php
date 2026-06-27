<?php

namespace Tests\Feature\Customers;

use App\Livewire\Customers\CustomerCreate;
use App\Livewire\Customers\CustomerEdit;
use App\Livewire\Customers\CustomerIndex;
use App\Livewire\Customers\CustomerShow;
use App\Models\Customer;
use App\Models\User;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'view customers']);
        Permission::create(['name' => 'create customers']);
        Permission::create(['name' => 'update customers']);
        Permission::create(['name' => 'delete customers']);

        $this->seed(SettingSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo('view customers', 'create customers', 'update customers', 'delete customers');
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('customers.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_without_permission_cannot_view_customers(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('customers.index'));

        $response->assertForbidden();
    }

    public function test_user_with_view_permission_can_view_customers(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CustomerIndex::class)
            ->assertOk()
            ->assertSee('Daftar Nasabah')
            ->assertSee('Tambah Nasabah');
    }

    public function test_user_with_view_permission_can_view_customer_detail(): void
    {
        $customer = Customer::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(CustomerShow::class, ['customer' => $customer])
            ->assertOk()
            ->assertSee($customer->full_name)
            ->assertSee($customer->customer_code);
    }

    public function test_user_without_create_permission_cannot_see_create_button(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view customers');

        $this->actingAs($user);

        Livewire::test(CustomerIndex::class)
            ->assertDontSee('Tambah Nasabah');
    }

    public function test_user_without_create_permission_cannot_view_create_page(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view customers');

        $this->actingAs($user);

        $response = $this->get(route('customers.create'));

        $response->assertForbidden();
    }

    public function test_user_with_create_permission_can_create_customer(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CustomerCreate::class)
            ->set('full_name', 'Budi Santoso')
            ->set('gender', 'L')
            ->set('phone', '08123456789')
            ->set('address', 'Jl. Merdeka No. 1')
            ->call('save');

        $this->assertDatabaseHas('customers', [
            'full_name' => 'Budi Santoso',
            'gender' => 'L',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
        ]);
    }

    public function test_customer_code_is_auto_generated(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CustomerCreate::class)
            ->set('full_name', 'Siti Aminah')
            ->call('save');

        $customer = Customer::where('full_name', 'Siti Aminah')->first();

        $this->assertNotNull($customer);
        $this->assertMatchesRegularExpression('/^NSB-\d{6}$/', $customer->customer_code);
    }

    public function test_user_without_update_permission_cannot_edit_customer(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view customers');
        $customer = Customer::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('customers.edit', $customer));

        $response->assertForbidden();
    }

    public function test_user_with_update_permission_can_update_customer(): void
    {
        $customer = Customer::factory()->create([
            'full_name' => 'Nama Lama',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(CustomerEdit::class, ['customer' => $customer])
            ->set('full_name', 'Nama Baru')
            ->call('save');

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'full_name' => 'Nama Baru',
        ]);
    }

    public function test_user_without_delete_permission_cannot_see_delete_button(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view customers');
        $customer = Customer::factory()->create();

        $this->actingAs($user);

        Livewire::test(CustomerIndex::class)
            ->assertDontSee('Hapus');
    }

    public function test_user_with_delete_permission_can_delete_customer(): void
    {
        $customer = Customer::factory()->create();

        $this->actingAs($this->admin);

        Livewire::test(CustomerIndex::class)
            ->call('delete', $customer->id);

        $this->assertSoftDeleted('customers', [
            'id' => $customer->id,
        ]);
    }

    public function test_full_name_is_required(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CustomerCreate::class)
            ->set('full_name', '')
            ->call('save')
            ->assertHasErrors('full_name');
    }

    public function test_gender_must_be_valid(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CustomerCreate::class)
            ->set('gender', 'X')
            ->call('save')
            ->assertHasErrors('gender');
    }

    public function test_phone_must_be_unique(): void
    {
        Customer::factory()->create(['phone' => '08123456789']);

        $this->actingAs($this->admin);

        Livewire::test(CustomerCreate::class)
            ->set('full_name', 'Test')
            ->set('phone', '08123456789')
            ->call('save')
            ->assertHasErrors('phone');
    }

    public function test_nik_must_be_unique(): void
    {
        Customer::factory()->create(['nik' => '1234567890123456']);

        $this->actingAs($this->admin);

        Livewire::test(CustomerCreate::class)
            ->set('full_name', 'Test')
            ->set('nik', '1234567890123456')
            ->call('save')
            ->assertHasErrors('nik');
    }

    public function test_search_by_name_returns_filtered_results(): void
    {
        Customer::factory()->create(['full_name' => 'Budi Santoso']);
        Customer::factory()->create(['full_name' => 'Siti Aminah']);

        $this->actingAs($this->admin);

        Livewire::test(CustomerIndex::class)
            ->set('search', 'Budi')
            ->assertSee('Budi Santoso')
            ->assertDontSee('Siti Aminah');
    }

    public function test_soft_deleted_customer_not_shown_in_index(): void
    {
        $customer = Customer::factory()->create(['full_name' => 'Akan Dihapus']);

        $this->actingAs($this->admin);

        Livewire::test(CustomerIndex::class)
            ->call('delete', $customer->id)
            ->assertDontSee('Akan Dihapus');
    }

    public function test_edit_phone_unique_excludes_own_record(): void
    {
        $customer = Customer::factory()->create([
            'full_name' => 'Test User',
            'phone' => '08123456789',
        ]);

        $this->actingAs($this->admin);

        Livewire::test(CustomerEdit::class, ['customer' => $customer])
            ->set('full_name', 'Test User Updated')
            ->set('phone', '08123456789')
            ->call('save')
            ->assertHasNoErrors('phone');
    }
}
