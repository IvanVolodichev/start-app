<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Sport;
use Tests\TestCase;

class AdminTest extends TestCase
{
    protected $admin;
    protected $regularUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->regularUser = User::factory()->create(['is_admin' => false]);
    }

    /** @test */
    public function admin_can_access_dashboard()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get(route('dashboard'));
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /** @test */
    public function regular_user_cannot_access_dashboard()
    {
        $this->actingAs($this->regularUser);
        
        $response = $this->get(route('dashboard'));
        
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_manage_categories()
    {
        $this->actingAs($this->admin);
        
        // Create a category
        $response = $this->post(route('categories.store'), [
            'name' => 'Test Category'
        ]);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category'
        ]);
        
        // Get the created category
        $category = Category::where('name', 'Test Category')->first();
        
        // Edit the category
        $response = $this->put(route('categories.update', $category), [
            'name' => 'Updated Category'
        ]);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Category'
        ]);
        
        // Delete the category
        $response = $this->delete(route('categories.destroy', $category));
        
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
        ]);
    }

    /** @test */
    public function regular_user_cannot_manage_categories()
    {
        $this->actingAs($this->regularUser);
        
        // Try to access categories index
        $response = $this->get(route('categories.index'));
        $response->assertStatus(403);
        
        // Try to create a category
        $response = $this->post(route('categories.store'), [
            'name' => 'Test Category'
        ]);
        $response->assertStatus(403);
        
        // Create a category as admin
        $this->actingAs($this->admin);
        $this->post(route('categories.store'), [
            'name' => 'Admin Category'
        ]);
        $category = Category::where('name', 'Admin Category')->first();
        
        // Switch back to regular user
        $this->actingAs($this->regularUser);
        
        // Try to edit the category
        $response = $this->put(route('categories.update', $category), [
            'name' => 'Updated by Regular User'
        ]);
        $response->assertStatus(403);
        
        // Try to delete the category
        $response = $this->delete(route('categories.destroy', $category));
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_manage_sports()
    {
        $this->actingAs($this->admin);
        
        // Create a category first
        $category = Category::factory()->create();
        
        // Create a sport
        $response = $this->post(route('sports.store'), [
            'name' => 'Test Sport',
            'description' => 'Test Description',
            'category_id' => $category->id
        ]);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('sports', [
            'name' => 'Test Sport',
            'category_id' => $category->id
        ]);
        
        // Get the created sport
        $sport = Sport::where('name', 'Test Sport')->first();
        
        // Edit the sport
        $response = $this->put(route('sports.update', $sport), [
            'name' => 'Updated Sport',
            'description' => 'Updated Description',
            'category_id' => $category->id
        ]);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('sports', [
            'id' => $sport->id,
            'name' => 'Updated Sport'
        ]);
        
        // Delete the sport
        $response = $this->delete(route('sports.destroy', $sport));
        
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('sports', [
            'id' => $sport->id
        ]);
    }
} 