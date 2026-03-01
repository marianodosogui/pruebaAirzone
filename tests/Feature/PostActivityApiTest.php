<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostActivityApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_post_owner_users_unique_and_comments(): void
    {
        $owner = User::factory()->create();
        $u1 = User::factory()->create();
        $u2 = User::factory()->create();

        $post = Post::factory()->create(['user_id' => $owner->id]);

        // u1 comenta 2 veces, u2 1 vez
        Comment::factory()->create(['post_id' => $post->id, 'user_id' => $u1->id]);
        Comment::factory()->create(['post_id' => $post->id, 'user_id' => $u1->id]);
        Comment::factory()->create(['post_id' => $post->id, 'user_id' => $u2->id]);

        $res = $this->getJson("/api/posts/{$post->id}/activity");

        $res->assertOk()
            ->assertJsonStructure([
                'body' => [
                    'post' => [
                        'id',
                        'title',
                        'short_content',
                        'owner' => ['id', 'username', 'full_name'],
                        'users',
                        'comments',
                    ]
                ]
            ]);

        // usuarios únicos
        $userIds = collect($res->json('body.post.users'))->pluck('id')->all();
        $this->assertCount(2, $userIds);
        $this->assertEqualsCanonicalizing([$u1->id, $u2->id], $userIds);

        // comentarios 3
        $this->assertCount(3, $res->json('body.post.comments'));
    }
}
