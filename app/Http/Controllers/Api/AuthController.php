<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AuthenticatedUserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function attempLogin (LoginRequest $request) {
    $user = User::where('email', $request->email)
      ->orWhere('username', $request->email)
      ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
      return response([
        'message' => 'These credentials do not match our records.'
      ], 404);
    }

    return new AuthenticatedUserResource($user);
  }

  public function showAuthenticatedUser (Request $request) {
    return new UserResource($request->user());
  }
}
