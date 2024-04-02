<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rols')->insert(['role' => 'Administrador']);
        DB::table('rols')->insert(['role' => 'Coordinador']);
        DB::table('rols')->insert(['role' => 'Usuario']);
    }
}
