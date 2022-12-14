<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        [
          'role_id' => Role::ADMIN,
          'username' => 'admin',
          'email' => 'admin@email.com',
          'password' => Hash::make('secret'),
          'first_name' => 'Super',
          'last_name' => 'Administrator'
        ]
      ]);
    }
}
