<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created(): void
    {
        $this->signIn();

        $title = fake()->sentence(3);

        $this->post('/api/v1/category/create', ['title' => $title, 'slug' => Str::slug($title)])
            ->assertStatus(201);

        $this->assertDatabaseHas('categories', ['title' => $title, 'slug' => Str::slug($title)]);
    }

    public function test_category_cant_store_invalid_category(): void
    {
        $this->signIn();

        $invalidCategories = $this->invalidCategories();

        foreach($invalidCategories as $invalidCategory) {

            $invalidData = $invalidCategory[0];
            $invalidFields = $invalidCategory[1];

            $this->post('/api/v1/category/create', $invalidData)
                ->assertSessionHasErrors($invalidFields)
                ->assertStatus(302);
        }
    }

    public function test_category_can_be_edited(): void
    {
        $this->signIn();

        $title = fake()->sentence(3);
        $category = Category::factory()->create();

        $this->put('/api/v1/category/' . $category->uuid, ['title' => $title, 'slug' => Str::slug($title)])
            ->assertStatus(200);

        $this->assertDatabaseHas('categories', ['title' => $title, 'slug' => Str::slug($title)]);
    }

    public function test_category_can_be_deleted(): void
    {
        $this->signIn();

        $category = Category::factory()->create();

        $this->delete('/api/v1/category/' . $category->uuid)->assertStatus(200);

        $this->assertDatabaseMissing('categories', ['uuid' => $category->uuid]);
    }

    public function invalidCategories()
    {
        return [
            [
                ['title' => fake()->randomNumber(), 'slug' => Str::slug(fake()->sentence(3))],
                ['title']
            ],
            [
                ['title' => fake()->sentence(3), 'slug' => fake()->randomNumber()],
                ['slug']
            ],
            [
                ['title' => fake()->randomNumber(), 'slug' => fake()->randomNumber()],
                ['title', 'slug']
            ],
            [
                ['title' => null, 'slug' => null],
                ['title', 'slug']
            ],
            [
                ['title' => Str::random(300), 'slug' => Str::random(300)],
                ['title', 'slug']
            ],
        ];
    }
}
