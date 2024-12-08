<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Clothes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class IntegrationTestV1Test extends TestCase
{
    use RefreshDatabase;

    /**
     * Test register -> login -> create categories -> create clothes -> show clothes.
     */
    public function test_register_login_create_categories_create_clothes_show_clothes()
    {
        // Register
        $registerResponse = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $registerResponse->assertRedirect('/home');

        // Login
        $loginResponse = $this->post(route('login'), [
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ]);
        $loginResponse->assertRedirect('/admin/dashboard');

        $user = User::where('email', 'testuser@example.com')->first();
        $this->assertAuthenticatedAs($user);

        // Create Category
        $categoryResponse = $this->post(route('admin.categories.store'), [
            'name' => 'Test Category',
        ]);
        $categoryResponse->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);

        // Create Clothes
        Storage::fake('public');
        $clothesResponse = $this->post(route('admin.clothes.store'), [
            'name' => 'Test Clothes',
            'description' => 'This is a test description',
            'price' => 100,
            'stock' => 10,
            'size' => 'M',
            'limited_edition' => true,
            'color' => ['Red', 'Blue'],
            'categories' => [Category::first()->id],
            'image' => UploadedFile::fake()->image('clothes.jpg'),
        ]);
        $clothesResponse->assertRedirect(route('admin.clothes.index'));
        $this->assertDatabaseHas('clothes', ['name' => 'Test Clothes']);

        // Show Clothes
        $clothes = Clothes::first();
        $showResponse = $this->get(route('admin.clothes.show', $clothes->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Test Clothes');
    }

    /**
     * Test register -> login -> edit clothes -> show clothes.
     */
    public function test_register_login_edit_clothes_show_clothes()
    {
        // Register
        $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Login
        $this->post(route('login'), [
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ]);

        // Create Clothes
        $clothes = Clothes::factory()->create([
            'name' => 'Original Name',
            'description' => 'Original Description',
        ]);

        // Edit Clothes
        $clothes->update([
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'color' => 'Red,Blue',
        ]);

        // Assert Update
        $this->assertDatabaseHas('clothes', ['name' => 'Updated Name']);

        // Show Clothes
        $response = $this->get(route('admin.clothes.show', $clothes->id));
        $response
            ->assertStatus(200);
        $response
            ->assertSee('Updated Name')
            ->assertSee('Red')
            ->assertSee('Blue')
            ->assertSee('Updated Description');
    }

    public function test_register_login_delete_clothes()
    {
        // Register
        $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Login
        $this->post(route('login'), [
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ]);

        // Create Clothes
        $clothes = Clothes::factory()->create([
            'name' => 'Test Clothes',
        ]);

        // Delete Clothes
        $clothes->delete();

        // Assert Deletion
        $this->assertDatabaseMissing('clothes', ['name' => 'Test Clothes']);
    }

    /**
     * Test register -> login -> create categories.
     */
    public function test_register_login_create_categories()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('admin.categories.store'), [
            'name' => 'Test Category',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
    }

    /**
     * Test register -> login -> edit categories.
     */
    public function test_register_login_edit_categories()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();

        $response = $this->put(route('admin.categories.update', $category->id), [
            'name' => 'Updated Category',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category']);
    }

    /**
     * Test register -> login -> delete categories.
     */
    public function test_register_login_delete_categories()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();

        $response = $this->delete(route('admin.categories.destroy', $category->id));
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
