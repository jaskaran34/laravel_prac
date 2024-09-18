<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    //use RefreshDatabase;
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function test_admin_login(){

        $user = User::factory()->create([
            'is_admin' => true,
        ]);
      
        $response = $this->actingAs($user)->get('/dashboard');


        //$response->assertViewHas('user');

        // Assert that the response contains the "admin" text
        //$response->assertSee('Admin');

        $response->assertViewHas('user.is_admin', true);
        //$response->assertViewHas('user.name', 'jaskaran');

        
    }
    public function test_non_admin_login(){

        $user = User::factory()->create([
            'is_admin' => false,
        ]);
      
        $response = $this->actingAs($user)->get('/dashboard');

        //$response->assertViewHas('user');

        // Assert that the response contains the "admin" text
        //$response->assertSee('Admin');

        $response->assertViewHas('user.is_admin', false);
        //$response->assertViewHas('user.name', 'jaskaran');

        
    }
    public function test_admin_can_add_products(){

        $user = User::factory()->create([
            'is_admin' => true,
        ]);

        $productData=[
            'name' => 'Test Product',
            'price' => 50.00,
            'added_by' => $user->id
        ];
  
        
        $response = $this->actingAs($user)->post('/add_product',$productData)->assertSessionHas('success', 'Product added successfully!');

        $this->assertDatabaseHas('products', $productData);

        
    }

    public function test_admin_can_DELETE_products(){

        $user = User::factory()->create([
            'is_admin' => true,
        ]);

        $productData = Product::factory()->create()->toArray();


        $response = $this->actingAs($user)->delete('/delete_product',[
            'delete_id' => $productData['id'],
        ]);

        //$this->assertDatabaseHas('products', $productData);
        $this->assertDatabaseMissing('products', [
            'id' => $productData['id'],
        ]);
        
    }

    /*
admin module test

1) only admin-user can add,edit and delete products
    */
}
