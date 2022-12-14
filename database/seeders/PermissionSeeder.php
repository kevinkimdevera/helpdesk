<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // PERMISSIONS
    DB::table('permissions')->delete();

    $groups = Permission::create([ 'code' => 'groups', 'name' => 'Manage Groups' ]);
    $users = Permission::create([ 'code' => 'users', 'name' => 'Manage User Accounts' ]);

    $tickets = Permission::create([ 'code' => 'tickets.manage', 'name' => 'Manage Tickets' ]);
    $tickets_escalate = Permission::create([ 'code' => 'tickets.escalate', 'name' => 'Escalate Tickets' ]);

    // ADMIN ROLES
    Role::find(Role::ADMIN)
      ->permissions()
      ->sync([
        $groups->id,
        $users->id,
        $tickets->id,
        $tickets_escalate->id
      ]);

    // GROUP ADMIN
    Role::find(Role::GROUP_ADMIN)
      ->permissions()
      ->sync([
        $tickets->id,
        $tickets_escalate->id
      ]);

    // HELPDESK USER
    Role::find(Role::GROUP_HELPDESK_USER)
      ->permissions()
      ->sync([
        $tickets->id,
      ]);
  }
}
