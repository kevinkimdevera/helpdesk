<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategoryType extends Model
{
  use HasFactory;

  protected $fillable = [
    'ticket_category_id',
    'name'
  ];
}
