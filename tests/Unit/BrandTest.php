<?php

namespace Tests\Unit;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function test_brand_can_be_created(): void
    {
        $this->signIn();

        $title = fake()->sentence(3);

        $this->post('/api/v1/brand/create', ['title' => $title, 'slug' => Str::slug($title)])
            ->assertStatus(201);

        $this->assertDatabaseHas('brands', ['title' => $title, 'slug' => Str::slug($title)]);
    }

    public function test_brand_cant_store_invalid_brand(): void
    {
        $this->signIn();

        $invalidBrands = $this->invalidBrands();

        foreach($invalidBrands as $invalidBrand) {

            $invalidData = $invalidBrand[0];
            $invalidFields = $invalidBrand[1];

            $this->post('/api/v1/brand/create', $invalidData)
                ->assertSessionHasErrors($invalidFields)
                ->assertStatus(302);
        }
    }

    public function test_brand_can_be_edited(): void
    {
        $this->signIn();

        $title = fake()->sentence(3);
        $brand = Brand::factory()->create();

        $this->put('/api/v1/brand/' . $brand->uuid, ['title' => $title, 'slug' => Str::slug($title)])
            ->assertStatus(200);

        $this->assertDatabaseHas('brands', ['title' => $title, 'slug' => Str::slug($title)]);
    }

    public function test_brand_can_be_deleted(): void
    {
        $this->signIn();

        $brand = Brand::factory()->create();

        $this->delete('/api/v1/brand/' . $brand->uuid)->assertStatus(200);

        $this->assertDatabaseMissing('brands', ['uuid' => $brand->uuid]);
    }

    public function invalidBrands()
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
