<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
  use RefreshDatabase;

  protected $seed = true;

  public function test_failed_validation_on_login_request()
  {
    $response = $this->post(route('api.auth.login'));
    $response->assertSessionHasErrors(['email', 'password']);
  }

  public function test_failed_login_using_not_existing_user () {
    $response = $this->post(route('api.auth.login'), [
      'email' => 'some_random_username',
      'password' => 'test_password'
    ]);

    $response->assertStatus(404);
  }

  public function test_failed_login_using_incorrect_password () {
    $user = User::factory()->create();

    $response = $this->post(route('api.auth.login'), [
      'email' => $user->email,
      'password' => 'incorrect_password'
    ]);

    $response->assertStatus(404);
  }

  public function test_user_can_login_using_email () {
    $user = User::factory()->create();

    $response = $this->postJson(route('api.auth.login'), [
      'email' => $user->email,
      'password' => 'secret'
    ]);

    $response->assertOk();
    $response->assertJsonStructure([
      'data' => [
        'user' => [
          'id',
          'avatar',
          'name',
          'email',
          'role' => [
            'id',
            'name',
            'permissions'
          ]
        ],
        'token'
      ]
      ]);
  }

  public function test_user_can_login_using_username () {
    $user = User::factory()->create();

    $response = $this->postJson(route('api.auth.login'), [
      'email' => $user->username,
      'password' => 'secret'
    ]);

    $response->assertOk();
    $response->assertJsonStructure([
      'data' => [
        'user' => [
          'id',
          'avatar',
          'name',
          'email',
          'role' => [
            'id',
            'name',
            'permissions'
          ]
        ],
        'token'
      ]
      ]);
  }
}
