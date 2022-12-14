<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\GroupResource;

class UserController extends Controller
{
  public function index (Request $request) {
    $active_groups = Group::active()
      ->orderBy('name')
      ->get();

    $roles = Role::all();

    $users = User::where('id', '>', 1)
      ->orderBy('last_name')
      ->orderBy('first_name')
      ->get();

    return [
      'groups' => GroupResource::collection($active_groups),
      'roles' => RoleResource::collection($roles),
      'users' => UserResource::collection($users)
    ];
  }
}
