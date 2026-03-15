<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'username' => 'testuser_123',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard', ['tab' => 'design']));

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('testuser_123', $user->username);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'username' => $user->username,
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard', ['tab' => 'design']));

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }

    public function test_design_settings_publish_persists_flat_color_background_for_public_profile(): void
    {
        $user = User::factory()->create([
            'username' => 'preview-user',
        ]);

        Profile::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'bio' => 'Old bio',
            'is_active' => true,
        ]);

        $payload = [
            'profile' => [
                'name' => $user->name,
                'username' => $user->username,
                'bio' => 'Updated bio',
            ],
            'theme' => [
                'preset' => 'forest',
            ],
            'background' => [
                'active_type' => 'color',
                'color' => '#163020',
            ],
            'buttons' => [
                'variant' => 'solid',
            ],
        ];

        $response = $this
            ->actingAs($user)
            ->patchJson(route('profile.design.update'), [
                'design_settings' => $payload,
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('design_settings.background.active_type', 'color')
            ->assertJsonPath('design_settings.background.color', '#163020');

        $profile = $user->profile()->firstOrFail()->fresh();

        $this->assertSame('#163020', data_get($profile->design_settings, 'background.color'));
        $this->assertSame('color', data_get($profile->design_settings, 'background.active_type'));

        $this->get(route('public.profile', $user->username))
            ->assertOk()
            ->assertSee('--bg-color: #163020', false)
            ->assertSee('background-color: #163020;', false);
    }

    public function test_glass_variant_keeps_button_color_tokens_when_published(): void
    {
        $user = User::factory()->create([
            'username' => 'glass-user',
        ]);

        Profile::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'is_active' => true,
        ]);

        $payload = [
            'profile' => [
                'name' => $user->name,
                'username' => $user->username,
                'bio' => '',
            ],
            'theme' => [
                'preset' => 'glass',
            ],
            'colors' => [
                'button_bg' => '#111111',
                'button_bg_hover' => '#222222',
                'button_border' => '#f5f5f5',
                'button_border_hover' => '#e5e5e5',
            ],
            'buttons' => [
                'variant' => 'glass',
            ],
        ];

        $response = $this
            ->actingAs($user)
            ->patchJson(route('profile.design.update'), [
                'design_settings' => $payload,
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('design_settings.buttons.variant', 'glass')
            ->assertJsonPath('design_settings.colors.button_bg', '#111111')
            ->assertJsonPath('design_settings.colors.button_bg_hover', '#222222');

        $profile = $user->profile()->firstOrFail()->fresh();

        $this->assertSame('#111111', data_get($profile->design_settings, 'colors.button_bg'));
        $this->assertSame('#222222', data_get($profile->design_settings, 'colors.button_bg_hover'));
    }

    public function test_background_video_can_be_uploaded_via_design_media_endpoint(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'username' => 'video-upload-user',
        ]);

        Profile::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('profile.design.media.upload'), [
                'media_type' => 'bg_video',
                'file' => UploadedFile::fake()->create('background.mp4', 3072, 'video/mp4'),
            ], [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('media_type', 'bg_video');

        $storedPath = Str::after($response->json('url'), '/storage/');

        Storage::disk('public')->assertExists($storedPath);
    }

    public function test_background_video_larger_than_eight_megabytes_is_rejected(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'username' => 'video-user',
        ]);

        Profile::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('profile.design.media.upload'), [
                'media_type' => 'bg_video',
                'file' => UploadedFile::fake()->create('background.mp4', 9216, 'video/mp4'),
            ], [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response
            ->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Video boyutu 8MB limitini asiyor.');
    }
}
