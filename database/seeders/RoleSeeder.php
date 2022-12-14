<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('roles')->insert([
      [
        'name' => 'Admin',
        'description' => 'Administrator Account'
      ],
      [
        'name' => 'Group Admin',
        'description' => 'Group Administrator Account'
      ],
      [
        'name' => 'Helpdesk User',
        'description' => 'Group Helpdesk User Account'
      ],
      [
        'name' => 'Standard User',
        'description' => 'Standard User Account'
      ],
    ]);
  }
}
