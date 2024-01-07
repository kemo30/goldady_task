<?php

namespace Tests\Unit;

use App\Http\Requests\PostRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\category;
use App\Models\post;
use App\Models\User;

class PostCrudTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;

    public function setUp()
    : void
    {
        parent::setUp();
    }

    public function test_getting_postes(): void
    {
        
        \App\Models\User::factory(10)->create();
        \App\Models\category::factory(10)->create();
        \App\Models\post::factory(10)->create();

        $response = $this->get('/api/posts');

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'posts' => [
                        '*' =>          
                            [
                            'id',
                            'title',
                            'post',
                            'date',
                            'category'=>[
                                'id',
                                'title',
                                'description',
                                'date',
                            ],
                            'user'=>[
                                'id',
                                'name',
                                'email',

                            ],

                        ]
            ],

            ]
        );
    }
    public function test_get_one_Post(): void{
        $user = User::create(['name' => 'test','email' => 'test@gmail.com','password' => 123123 ]);
        $categiry = category::create([
            'title'   => 'test',
            'description' => 'test test test',
        ]);

        $request = new PostRequest();
        $request->setMethod('POST');
        $attributes = [
                'title'   => 'test',
                'post' => 'test test test',
                'user_id' => $user->id,
                'category_id' => $categiry->id

        ];

        $request->merge($attributes);

        $entity= post::create($request->all());
        

        $response = $this->getJson('/api/posts/'. $entity->id);
        $response->assertStatus(200);
        $responseItem = $response->json();
    }

    public function test_create_post(){
      
            $user = User::create(['name' => 'test','email' => 'test@gmail.com','password' => 123123 ]);
            $categiry = category::create([
                'title'   => 'test',
                'description' => 'test test test',
                'user_id' => $user->id,
            ]);
    
            $response = $this->actingAs($user)->postJson('/api/posts', [
                        'title'   => 'test',
                        'post' => 'test test test',
                        'category_id' => $categiry->id,
                        'user_id' => $user->id,      
            ]);
                    $response->assertStatus(201);
    } 

    public function test_update_post(){
        $request = new PostRequest();
        $request->setMethod('PUT');
        $user = User::create(['name' => 'test','email' => 'test@gmail.com','password' => 123123 ]);
        $categiry = category::create([
            'title'   => 'test',
            'description' => 'test test test',
            'user_id' => $user->id,
        ]);

        $attributes = [
            'title'   => 'test update',
            'post' => 'test update ',
            'user_id' => $user->id,
            'category_id' => $categiry->id,

        ];

        $request->merge($attributes);
        $entity = post::create($request->all());
       
        $response = $this->actingAs($user)
        ->putJson('/api/posts/'.$entity->id, $attributes);


      $response->assertStatus(201);
    }

    public function test_delete_post(){
        $request = new PostRequest();

        $request->setMethod('delete');

        $user = User::create(['name' => 'test','email' => 'test@gmail.com','password' => 123123 ]);
        $categiry = category::create([
            'title'   => 'test',
            'description' => 'test test test',
            'user_id' => $user->id,
        ]);
        $attributes = [
            'title'   => 'test update',
            'post' => 'test update ',
            'user_id' => $user->id,
            'category_id' => $categiry->id,
        ];

        $request->merge($attributes);
        $entity = post::create( $attributes);
       
        $response = $this->actingAs($user)
        ->deleteJson('/api/posts/'. $entity->id);


      $response->assertStatus(200); 
        
    }

}
