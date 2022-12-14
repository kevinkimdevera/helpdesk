<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'role_id',
    'last_name',
    'first_name',
    'middle_name',
    'username',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getNameAttribute () {
    return "$this->first_name $this->last_name";
  }

  public function getAvatarAttribute () {
    $fn = $this->first_name[0];
    $ln = $this->last_name[0];

    return "$fn$ln";
  }

  public function hasPermission ($permission) {
    return $this->role
      ->permissions
      ->pluck('code')
      ->contains($permission);
  }

  public function role () {
    return $this->belongsTo(Role::class);
  }

  public function groups () {
    return $this->belongsToMany(Group::class);
  }
}
