<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_interacting_with_headers(): void
    {
        $responce = $this->withHeaders([
            'X-Header' => 'Value',
        ])->get('/post/{id}', ['id' => 2]);

        $responce->assertStatus(302);
    }

    public function test_update_post():void
    {
        $responce = $this->patch('/post-update/1', [
            'title' => 'Test update',
            'description' => 'Test description'
        ]);

        $responce->assertStatus(200);
    }

    public function test_create_post(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('public');

        $data = [
            'title' => 'Post',
            'description' => 'Description',
            'file' => UploadedFile::fake()->image('new_post_image.jpg'),
        ];

        $responce = $this->post('/post', $data);

        $responce->assertStatus(201);
        $this->assertDatabaseHas('posts', ['title' => 'Post']);

        Storage::disk('public')->assertExists('post_image/' . $data['image']->hasName());

    }
}
