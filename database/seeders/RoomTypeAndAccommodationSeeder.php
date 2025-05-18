<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeAndAccommodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('room_types')->insert([
            ['nombre' => 'Estándar'],
            ['nombre' => 'Junior'],
            ['nombre' => 'Suite'],
        ]);

        DB::table('accommodations')->insert([
            ['nombre' => 'Sencilla'],
            ['nombre' => 'Doble'],
            ['nombre' => 'Triple'],
            ['nombre' => 'Cuádruple'],
        ]);
    }
}
