<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories(): void
    {
        Category::factory()->count(3)->create();

        $res = $this->getJson('/api/categories');

        $res->assertOk()
            ->assertJsonStructure([
                'data' => [
                    ['id', 'name', 'slug', 'visible']
                ]
            ]);
    }

    public function test_can_create_category_and_validates_unique_slug(): void
    {
        $payload = [
            'name' => 'Technology',
            'slug' => 'technology',
            'visible' => true,
        ];

        $this->postJson('/api/categories', $payload)
            ->assertCreated()
            ->assertJsonPath('data.slug', 'technology');

        // mismo slug debe fallar
        $this->postJson('/api/categories', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors(['slug']);
    }

    public function test_can_show_category(): void
    {
        $cat = Category::factory()->create();

        $this->getJson("/api/categories/{$cat->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $cat->id);
    }

    public function test_can_update_category(): void
    {
        $cat = Category::factory()->create(['slug' => 'old']);

        $this->putJson("/api/categories/{$cat->id}", [
            'name' => 'New Name',
            'slug' => 'old', // no debe fallar porque es el mismo registro
        ])->assertOk()
          ->assertJsonPath('data.name', 'New Name');
    }

    public function test_cannot_delete_category_if_attached_to_posts(): void
    {
        // Este test asume que implementaste la política "RESTRICT + 409"
        $cat = Category::factory()->create();

        // simulamos attach en tabla pivote
        $post = \App\Models\Post::factory()->create();
        $post->categories()->attach($cat->id);

        $this->deleteJson("/api/categories/{$cat->id}")
            ->assertStatus(409);
    }
}
