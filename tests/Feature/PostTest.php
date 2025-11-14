<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que un usuario autenticado puede ver la lista de posts
     */
    public function test_authenticated_user_can_view_posts_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.index'));

        $response->assertStatus(200);
    }

    /**
     * Test que un usuario no autenticado no puede ver posts
     */
    public function test_guest_cannot_view_posts(): void
    {
        $response = $this->get(route('posts.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test que un usuario autenticado puede crear un post
     */
    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $postData = [
            'title' => 'Test Post Title',
            'content' => 'This is test content for the post.',
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
        ]);
    }

    /**
     * Test que un usuario autenticado puede ver un post específico
     */
    public function test_authenticated_user_can_view_single_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.show', $post));

        $response->assertStatus(200);
    }

    /**
     * Test que un usuario autenticado puede editar su propio post
     */
    public function test_authenticated_user_can_update_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'title' => 'Updated Post Title',
            'content' => 'Updated content',
        ];

        $response = $this->actingAs($user)->put(route('posts.update', $post), $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post Title',
        ]);
    }

    /**
     * Test que un usuario autenticado puede eliminar su propio post
     */
    public function test_authenticated_user_can_delete_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('posts.destroy', $post));

        $response->assertRedirect();
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
