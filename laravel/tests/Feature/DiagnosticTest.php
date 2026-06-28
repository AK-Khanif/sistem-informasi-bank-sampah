<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Collector;
use App\Models\User;
use App\Models\WasteCategory;
use App\Models\WasteType;
use App\Models\WastePrice;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class DiagnosticTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $names = [
            'view customers', 'create customers', 'update customers', 'delete customers',
            'view waste-categories', 'create waste-categories', 'update waste-categories', 'delete waste-categories',
            'view waste-types', 'create waste-types', 'update waste-types', 'delete waste-types',
            'view waste-prices', 'create waste-prices', 'update waste-prices', 'delete waste-prices',
            'view collectors', 'create collectors', 'update collectors', 'delete collectors',
            'view settings', 'update settings',
            'view dashboard',
        ];

        foreach ($names as $name) {
            Permission::create(['name' => $name]);
        }

        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo($names);
    }

    public function test_gate_discovers_all_policies(): void
    {
        $models = [
            ['viewAny', Customer::class],
            ['viewAny', Collector::class],
            ['viewAny', WasteCategory::class],
            ['viewAny', WasteType::class],
            ['viewAny', WastePrice::class],
            ['view', Setting::class],
        ];

        foreach ($models as [$ability, $model]) {
            $result = Gate::forUser($this->admin)->check($ability, $model);
            $this->assertTrue(
                $result,
                "Gate::check('{$ability}', {$model}) should be true"
            );
        }
    }

    public function test_authorize_on_all_master_data_pages(): void
    {
        $this->actingAs($this->admin);

        $routes = [
            'customers.index',
            'customers.create',
            'waste-categories.index',
            'waste-categories.create',
            'waste-types.index',
            'waste-types.create',
            'waste-prices.index',
            'waste-prices.create',
            'collectors.index',
            'collectors.create',
            'settings.index',
        ];

        foreach ($routes as $route) {
            $response = $this->get(route($route));
            $response->assertStatus(200);
        }
    }

    public function test_unauthorized_user_gets_403(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view collectors');
        $this->actingAs($user);

        $response = $this->get(route('customers.index'));
        $response->assertForbidden();
    }
}
