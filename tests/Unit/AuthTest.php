<?php

namespace Tests\Unit;

use App\Http\Requests\loginRequest;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
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
  public function test_login(){
    $request = new loginRequest();
 

    $request->setMethod('POST');

        $attributes = [
                'name' =>'test',
                'email'   => 'test@gmail.com',
                'password' => 123123,
        ];

        $request->merge($attributes);

        User::create($request->all());

        $response = $this->postJson('/api/login',[
            'email'   => 'test@gmail.com',
            'password' => 123123,
        ]);

        $response->assertStatus(200);
  }

  public function test_register(){

    $response = $this->postJson('/api/register',[
        'name' => 'karim',
        'email'   => 'test@gmail.com',
        'password' => "123123123",
    ]);
    $response->assertStatus(201);
  }

  public function test_register_invalid_data(){
    $response = $this->postJson('/api/register',[
        'name' => 'karim',
        'email'   => 'test',
        'password' => "123123123",
    ]);
    $response->assertStatus(422);

  }
}
