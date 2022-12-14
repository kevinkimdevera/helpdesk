<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  use HasFactory;

  const ADMIN = 1;
  const GROUP_ADMIN = 2;
  const GROUP_HELPDESK_USER = 3;
  const USER = 4;

  protected $fillable = [
    'name',
    'description'
  ];

  public function getIsLockedAttribute() : bool {
    return $this->id === self::ADMIN;
  }

  public function permissions () {
    return $this->belongsToMany(Permission::class);
  }
}
