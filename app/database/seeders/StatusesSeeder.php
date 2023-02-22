<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'name' => 'в ожидании'
        ]);
        DB::table('statuses')->insert([
            'name' => 'в разработке',
        ]);
        DB::table('statuses')->insert([
            'name' => 'на тестировании',
        ]);
        DB::table('statuses')->insert([
            'name' => 'на проверке',
        ]);
        DB::table('statuses')->insert([
            'name' => 'выполнено',
        ]);
    }
}
