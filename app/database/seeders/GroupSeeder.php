<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'name' => 'Администратор',
            'slug' => 'admin',
        ]);
        DB::table('groups')->insert([
            'name' => 'Пользователь',
            'slug' => 'user',
        ]);
    }
}
