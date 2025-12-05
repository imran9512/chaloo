<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class TransporterActivationTest extends TestCase
{
    use RefreshDatabase;

    public function test_transporter_can_view_activation_page()
    {
        $transporter = User::factory()->create(['role' => 'transporter', 'status' => 'pending']);

        $response = $this->actingAs($transporter)->get(route('transporter.activation'));

        $response->assertStatus(200);
        $response->assertSeeLivewire('transporter.activation');
    }

    public function test_transporter_can_upload_documents()
    {
        Storage::fake('public');
        $transporter = User::factory()->create(['role' => 'transporter', 'status' => 'pending']);

        $idCard = UploadedFile::fake()->image('id_card.jpg');
        $license = UploadedFile::fake()->image('license.jpg');

        Livewire::actingAs($transporter)
            ->test('transporter.activation')
            ->set('id_card_image', $idCard)
            ->set('license_image', $license)
            ->call('submit');

        $transporter->refresh();

        $this->assertEquals('pending_approval', $transporter->status);
        $this->assertNotNull($transporter->id_card_image);
        $this->assertNotNull($transporter->license_image);
        $this->assertTrue(Storage::disk('public')->exists($transporter->id_card_image));
        $this->assertTrue(Storage::disk('public')->exists($transporter->license_image));
    }

    public function test_active_transporter_redirected_from_activation()
    {
        $transporter = User::factory()->create(['role' => 'transporter', 'status' => 'active']);

        $response = $this->actingAs($transporter)->get(route('transporter.activation'));

        $response->assertRedirect(route('transporter.dashboard'));
    }
}
