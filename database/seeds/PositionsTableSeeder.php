<?php

use Illuminate\Database\Seeder;
use App\Position;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name' => 'Kepala Sekolah'
        ]);
        Position::create([
            'name' => 'Guru Umum'
        ]);
        Position::create([
            'name' => 'Guru Agama'
        ]);
        Position::create([
            'name' => 'Guru Penjas'
        ]);
        Position::create([
            'name' => 'Penjaga Sekolah'
        ]);
    }
}
