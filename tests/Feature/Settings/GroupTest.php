<?php

namespace Tests\Feature\Settings;

use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GroupTest extends TestCase
{
  use RefreshDatabase;
  protected $seed = true;
  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function test_unauthorized_when_getting_groups_list() {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $response = $this->get(route('api.settings.groups.index'));
    $response->assertStatus(403);
  }

  public function test_list_of_groups_was_fetched () {
    $groups = Group::factory()->count(5)->make();

    $admin = User::factory()->role(Role::ADMIN)->create();
    Sanctum::actingAs($admin);
    $response = $this->getJson(route('api.settings.groups.index'));

    $response->assertOk();
    $response->assertJsonStructure([
      'data' => [
        '*' => [
          'id',
          'code',
          'name',
          'users',
          'status' => [
            'active',
            'color',
            'icon',
            'text'
          ]
        ]
      ]
    ]);

  }

  public function test_failed_validation_when_creating_group () {
    $admin = User::factory()->role(Role::ADMIN)->create();
    Sanctum::actingAs($admin);

    $response = $this->postJson(route('api.settings.groups.store'));
    $response->assertStatus(422);
    $response->assertJsonStructure([
      'message',
      'errors' => [
        'name'
      ]
    ]);
  }

  public function test_group_was_created () {
    $admin = User::factory()->role(Role::ADMIN)->create();
    Sanctum::actingAs($admin);

    $response = $this->postJson(route('api.settings.groups.store'), [
      'name' => 'Test Group'
    ]);
    $response->assertOk();
    $response->assertExactJson([
      'saved' => true
    ]);
  }

  public function test_failed_validation_when_updating_group () {
    $group = Group::factory()->create([
      'name' => 'Test Group'
    ]);

    $admin = User::factory()->role(Role::ADMIN)->create();
    Sanctum::actingAs($admin);

    $response = $this->patchJson(route('api.settings.groups.update', [ 'group' => $group ]), [ ]);
    $response->assertStatus(422);
    $response->assertJsonStructure([
      'message',
      'errors' => [
        'name'
      ]
    ]);
  }

  public function test_group_was_updated () {
    $group = Group::factory()->create([
      'name' => 'Test Group'
    ]);

    $admin = User::factory()->role(Role::ADMIN)->create();
    Sanctum::actingAs($admin);

    $response = $this->patchJson(route('api.settings.groups.update', [ 'group' => $group ]), [
      'name' => 'Updated Group Name'
    ]);
    $response->assertOk();
    $response->assertExactJson([
      'updated' => true
    ]);
  }

  public function test_group_was_deleted () {
    $group = Group::factory()->create([
      'name' => 'Test Group'
    ]);

    $admin = User::factory()->role(Role::ADMIN)->create();
    Sanctum::actingAs($admin);

    $response = $this->deleteJson(route('api.settings.groups.destroy', [ 'group' => $group ]));
    $response->assertOk();
    $response->assertExactJson([
      'deleted' => true
    ]);
  }
}
