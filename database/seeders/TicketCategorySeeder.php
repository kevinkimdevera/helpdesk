<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('ticket_categories')->delete();

      $c_troubleshooting = TicketCategory::create([
        'name' => 'Computer Troubleshooting'
      ]);

      $c_network = TicketCategory::create([
        'name' => 'Network Issue'
      ]);

      $c_others = TicketCategory::create([
        'name' => 'Others'
      ]);

      $c_troubleshooting->types()->createMany([
        ['name' =>'Repair'],
      ]);

      $c_network->types()->createMany([
        ['name' => 'Internet Connection'],
      ]);
    }
}
