<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('ticket_priorities')->insert([
        ['name' => 'Low'],
        ['name' => 'Medium'],
        ['name' => 'High'],
        ['name' => 'Urgent'],
      ]);
    }
}
