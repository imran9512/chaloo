<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class AdminFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_pending_approvals_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.approvals'));

        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.pending-approvals');
    }

    public function test_admin_can_approve_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'transporter', 'status' => 'pending_approval']);

        Livewire::actingAs($admin)
            ->test('admin.pending-approvals')
            ->call('approve', $user->id);

        $this->assertEquals('active', $user->fresh()->status);
    }

    public function test_admin_can_reject_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'transporter', 'status' => 'pending_approval']);

        Livewire::actingAs($admin)
            ->test('admin.pending-approvals')
            ->call('reject', $user->id);

        $this->assertEquals('suspended', $user->fresh()->status);
    }

    public function test_admin_can_view_vehicle_types_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.vehicle-types'));

        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.vehicle-types');
    }

    public function test_admin_can_create_vehicle_type()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin)
            ->test('admin.vehicle-types')
            ->set('name', 'Sedan')
            ->set('capacity', 4)
            ->set('status', true)
            ->call('store');

        $this->assertDatabaseHas('vehicle_types', [
            'name' => 'Sedan',
            'capacity' => 4,
        ]);
    }

    public function test_admin_can_update_vehicle_type()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $type = VehicleType::create(['name' => 'Sedan', 'capacity' => 4, 'status' => true]);

        Livewire::actingAs($admin)
            ->test('admin.vehicle-types')
            ->call('edit', $type->id)
            ->set('name', 'Luxury Sedan')
            ->call('update');

        $this->assertDatabaseHas('vehicle_types', [
            'id' => $type->id,
            'name' => 'Luxury Sedan',
        ]);
    }

    public function test_admin_can_delete_vehicle_type()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $type = VehicleType::create(['name' => 'Sedan', 'capacity' => 4, 'status' => true]);

        Livewire::actingAs($admin)
            ->test('admin.vehicle-types')
            ->call('delete', $type->id);

        $this->assertDatabaseMissing('vehicle_types', ['id' => $type->id]);
    }
}
