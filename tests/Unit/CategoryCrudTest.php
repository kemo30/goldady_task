<?php

namespace Tests\Unit;

use App\Http\Requests\CategoriesRequest;
use App\Http\Requests\PostRequest;
use App\Models\category;
use App\Models\post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CategoryCrudTest extends TestCase
{

    use RefreshDatabase;

    public function setUp()
    : void
    {
        parent::setUp();
    }
    /**
     * A basic unit test example.
     */
    public function test_getting_categorys(): void
    {
      
        \App\Models\category::factory(10)->create();

        $response = $this->get('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'categories' => [
                        '*' =>          
                            [
                            'id',
                            'title',
                            'description',
                            'date',

                        ]
            ],

            ]
        );
    }

    public function test_get_One_category(){
        $request = new CategoriesRequest();
        $request->setMethod('POST');
        $attributes = [
                'title'   => 'test',
                'description' => 'test test test',
               
        ];

        $request->merge($attributes);

        $entity= category::create($request->all());

        $response = $this->getJson('/api/categories/'. $entity->id);
        $response->assertStatus(200);
        $responseItem = $response->json();
      
    }

    public function test_create_category(){
        $user = User::create(['name' => 'test','email' => 'test@gmail.com','password' => 123123 ]);
         $token = $user->createToken('bookstore')->accessToken;

        $response = $this->actingAs($user)->postJson('/api/categories', [
                    'title'   => 'test',
                    'description' => 'test test test',
        ]);
                $response->assertStatus(201);
            
    }


    public function test_update_category(){
        $request = new CategoriesRequest();
        $request->setMethod('PUT');
        $user = User::create(['name' => 'test','email' => 'test@gmail.com','password' => 123123 ]);
        $attributes = [
            'title'   => 'test update',
            'description' => 'test update ',
            'user_id' => $user->id,
        ];

        $request->merge($attributes);
        $entity = category::create($request->all());
       
        $response = $this->actingAs($user)
        ->putJson('/api/categories/'.$entity->id, $attributes);


      $response->assertStatus(200);
    }

    public function test_delete_category(){
        $request = new CategoriesRequest();
        $request->setMethod('delete');
        $user = User::create(['name' => 'test','email' => 'test@gmail.com','password' => 123123 ]);
        $attributes = [
            'title'   => 'test update',
            'description' => 'test update ',
            'user_id' => $user->id,
        ];

        $request->merge($attributes);
        $entity = category::create($request->all());
       
        $response = $this->actingAs($user)
        ->deleteJson('/api/categories/'.$entity->id, $attributes);


      $response->assertStatus(200); 
        
    }

}
