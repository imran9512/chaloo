<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class TransporterVehicleTest extends TestCase
{
    use RefreshDatabase;

    public function test_transporter_can_view_vehicle_list()
    {
        $transporter = User::factory()->create(['role' => 'transporter']);
        $this->actingAs($transporter)->get(route('transporter.vehicles'))->assertStatus(200);
    }

    public function test_transporter_can_create_vehicle()
    {
        $transporter = User::factory()->create(['role' => 'transporter']);
        $type = VehicleType::create(['name' => 'Sedan', 'capacity' => 4, 'status' => true]);

        Livewire::actingAs($transporter)
            ->test('transporter.vehicle-form')
            ->set('vehicle_type_id', $type->id)
            ->set('name', 'My Car')
            ->set('brand', 'Toyota')
            ->set('model', 'Corolla')
            ->set('year', 2022)
            ->set('registration_number', 'ABC-123')
            ->set('color', 'White')
            ->set('daily_rate', 5000)
            ->set('city', 'Lahore')
            ->set('description', 'Good car')
            ->call('save')
            ->assertRedirect(route('transporter.vehicles'));

        $this->assertDatabaseHas('vehicles', [
            'name' => 'My Car',
            'user_id' => $transporter->id,
        ]);
    }

    public function test_transporter_can_update_vehicle()
    {
        $transporter = User::factory()->create(['role' => 'transporter']);
        $type = VehicleType::create(['name' => 'Sedan', 'capacity' => 4, 'status' => true]);
        $vehicle = Vehicle::create([
            'user_id' => $transporter->id,
            'vehicle_type_id' => $type->id,
            'name' => 'Old Car',
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2020,
            'registration_number' => 'XYZ-789',
            'daily_rate' => 4000,
            'city' => 'Karachi',
            'status' => 'available',
            'is_approved' => true,
        ]);

        Livewire::actingAs($transporter)
            ->test('transporter.vehicle-form', ['vehicle' => $vehicle])
            ->set('name', 'Updated Car')
            ->call('save')
            ->assertRedirect(route('transporter.vehicles'));

        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicle->id,
            'name' => 'Updated Car',
            'is_approved' => false, // Should reset to false
        ]);
    }

    public function test_transporter_cannot_edit_others_vehicle()
    {
        $transporter1 = User::factory()->create(['role' => 'transporter']);
        $transporter2 = User::factory()->create(['role' => 'transporter']);
        $type = VehicleType::create(['name' => 'Sedan', 'capacity' => 4, 'status' => true]);
        $vehicle = Vehicle::create([
            'user_id' => $transporter2->id,
            'vehicle_type_id' => $type->id,
            'name' => 'Other Car',
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2020,
            'registration_number' => 'XYZ-789',
            'daily_rate' => 4000,
            'city' => 'Karachi',
            'status' => 'available',
        ]);

        $this->actingAs($transporter1)
            ->get(route('transporter.vehicles.edit', $vehicle))
            ->assertStatus(403);
    }
}
