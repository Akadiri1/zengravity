<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;

class ScanUploadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a valid file upload.
     */
    public function test_authenticated_user_can_upload_valid_file(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('scan.jpg');

        $response = $this->actingAs($user)
            ->post(route('scan.upload'), [
                'media' => $file,
            ]);

        // Expect redirect to scan.show
        $response->assertRedirect();
        
        // Assert file exists in storage
        // Note: The controller logic likely stores it in 'scans' folder or similar.
        // We'd need to check the database to know the exact path or check general existence.
        // For now, let's just assert the database has a scan record.
        $this->assertDatabaseHas('scans', [
            'user_id' => $user->id,
            // 'file_path' => ... we don't know the exact hash name easily without more logic
        ]);
    }

    /**
     * Test invalid file upload (wrong type).
     */
    public function test_upload_rejects_invalid_file_type(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('document.pdf', 100); // PDF not allowed

        $response = $this->actingAs($user)
            ->post(route('scan.upload'), [
                'media' => $file,
            ]);

        $response->assertSessionHasErrors('media');
    }

    /**
     * Test unauthenticated access.
     */
    public function test_guest_cannot_upload_file(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('scan.jpg');

        $response = $this->post(route('scan.upload'), [
            'media' => $file,
        ]);

        $response->assertRedirect(route('login'));
    }
}
