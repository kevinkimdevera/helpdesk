<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      GroupSeeder::class,
      RoleSeeder::class,
      PermissionSeeder::class,
      AdminUserSeeder::class,
      TicketStatusSeeder::class,
      TicketPrioritySeeder::class,
      TicketCategorySeeder::class
    ]);
  }
}
