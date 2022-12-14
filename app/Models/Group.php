<?php

namespace App\Models;

use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected static function newFactory() {
    return GroupFactory::new();
  }

  protected $fillable = [
    'name',
    'active'
  ];

  protected $casts = [
    'active' => 'boolean'
  ];

  public function scopeActive ($query) {
    return $query->where('active', true);
  }

  public function users () {
    return $this->belongsToMany(User::class);
  }
}
