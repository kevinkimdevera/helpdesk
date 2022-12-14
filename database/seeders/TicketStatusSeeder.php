<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('ticket_statuses')->insert([
        ['name' => 'New'],
        ['name' => 'Open'],
        ['name' => 'Pending'],
        ['name' => 'On-hold'],
        ['name' => 'Solved'],
        ['name' => 'Closed'],
        ['name' => 'Archived'],
      ]);
    }
}
