<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Clothes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClothesControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * Test index method - displays all clothes.
     */
    public function test_index_displays_clothes_list()
    {
        Clothes::factory()->count(5)->create();

        $response = $this->get(route('admin.clothes.index'));

        $response->assertStatus(200);
        $response->assertViewHas('clothes');
    }

    /**
     * Test store method - stores a new clothes item.
     */
    public function test_store_creates_new_clothes()
    {
        Storage::fake('public');
        $category = Category::factory()->create();

        $data = [
            'name' => 'Test Clothes',
            'description' => 'This is a test description',
            'price' => 100,
            'stock' => 10,
            'size' => 'M',
            'limited_edition' => true,
            'color' => ['Red', 'Blue'], // Pass as array
            'categories' => [$category->id],
            'image' => UploadedFile::fake()->image('clothes.jpg')
        ];

        $response = $this->post(route('admin.clothes.store'), $data);

        $response->assertRedirect(route('admin.clothes.index'));
        $this->assertDatabaseHas('clothes', ['name' => 'Test Clothes']);
        // $this->assertTrue(Storage::disk('public')->exists('images/clothes/' . $data['image']->hashName()));
    }

    /**
     * Test show method - displays specific clothes details.
     */
    public function test_show_displays_clothes_details()
    {
        $clothes = Clothes::factory()->create();

        $response = $this->get(route('admin.clothes.show', $clothes->id));
        $response->assertSee($clothes->name);
        $response->assertSee($clothes->description);
        
        // $response->assertStatus(200);
        // $response->assertViewHas('clothes');
        
        // $this->assertContains('expected_value', $response);

        // $this->assertTrue($response->contains('cloth'));

        
    }

    /**
     * Test update method - updates existing clothes.
     */
    public function test_update_edits_clothes()
    {
        Storage::fake('public');
        $clothes = Clothes::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'name' => 'Updated Clothes',
            'description' => 'Updated description',
            'price' => 150,
            'stock' => 5,
            'size' => 'L',
            'limited_edition' => false,
            'color' => ['Green', 'Yellow'], // Pass as array
            'categories' => [$category->id],
            'image' => UploadedFile::fake()->image('new_clothes.jpg')
        ];

        $response = $this->put(route('admin.clothes.update', $clothes->id), $data);

        $response->assertRedirect(route('admin.clothes.index'));
        $this->assertDatabaseHas('clothes', ['name' => 'Updated Clothes']);
        // $this->assertTrue(Storage::disk('public')->exists('images/clothes/' . $data['image']->hashName()));
    }

    /**
     * Test destroy method - deletes clothes.
     */
    public function test_destroy_deletes_clothes()
    {
        $clothes = Clothes::factory()->create();

        $response = $this->delete(route('admin.clothes.destroy', $clothes->id));

        $response->assertRedirect(route('admin.clothes.index'));
        $this->assertDatabaseMissing('clothes', ['id' => $clothes->id]);
    }
    public function test_store_fails_with_incomplete_data()
    {
        // Membuat kategori untuk pakaian
        $category = Category::factory()->create();

        // Data yang tidak lengkap (nama pakaian kosong)
        $data = [
            'name' => '', // Nama kosong
            'description' => 'Description for clothes',
            'price' => 100,
            'stock' => 10,
            'size' => 'M',
            'limited_edition' => true,
            'color' => ['Red', 'Blue'],
            'categories' => [$category->id],
            'image' => UploadedFile::fake()->image('clothes.jpg')
        ];

        // Mengirimkan request untuk menyimpan pakaian
        $response = $this->post(route('admin.clothes.store'), $data);

        // Memastikan pesan kesalahan ditampilkan untuk field 'name'
        $response->assertSessionHasErrors('name');

        // Memastikan data pakaian tidak tersimpan di database
        $this->assertDatabaseMissing('clothes', ['name' => '']);
    }
}
