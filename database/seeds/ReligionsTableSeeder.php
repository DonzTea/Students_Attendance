<?php

use Illuminate\Database\Seeder;
use App\Religion;

class ReligionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Religion::create(['name' => 'Islam']);
        Religion::create(['name' => 'Protestan']);
        Religion::create(['name' => 'Katolik']);
        Religion::create(['name' => 'Hindu']);
        Religion::create(['name' => 'Buddha']);
        Religion::create(['name' => 'Khonghucu']);
    }
}
