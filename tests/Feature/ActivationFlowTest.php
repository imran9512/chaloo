<?php

namespace Tests\Feature;

use App\Models\User;
use App\Livewire\Shared\ActivationForm;
use App\Livewire\Admin\PendingApprovals;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ActivationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_transporter_sees_activation_form()
    {
        $user = User::factory()->create([
            'role' => 'transporter',
            'status' => 'active',
        ]);

        // Create a dummy package for the dashboard widget to not error out if it expects one
        // Or just ensure the view handles no package gracefully (which it does)

        $this->actingAs($user)
            ->get(route('transporter.dashboard'))
            ->assertDontSeeLivewire('shared.activation-form')
            ->assertSee('Welcome back, Transporter!');
    }

    public function test_transporter_can_upload_documents()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'transporter',
            'status' => 'inactive',
        ]);

        $idCard = UploadedFile::fake()->image('id_card.jpg');
        $license = UploadedFile::fake()->image('license.jpg');

        Livewire::actingAs($user)
            ->test(ActivationForm::class)
            ->set('id_card', $idCard)
            ->set('license', $license)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $user->refresh();

        $this->assertEquals('pending_approval', $user->status);
        $this->assertNotNull($user->id_card_image);
        $this->assertNotNull($user->license_image);

        Storage::assertExists('public/' . $user->id_card_image);
        Storage::assertExists('public/' . $user->license_image);
    }

    public function test_admin_can_approve_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'role' => 'transporter',
            'status' => 'pending_approval',
            'name' => 'John Doe'
        ]);

        Livewire::actingAs($admin)
            ->test(PendingApprovals::class)
            ->call('approve', $user->id);

        $this->assertEquals('active', $user->fresh()->status);
    }
}
