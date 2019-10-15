<?php

use Illuminate\Database\Seeder;
use App\Education;

class EducationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Education::create(['name' => 'Pendidikan Tinggi']);
        Education::create(['name' => 'Sekolah Menengah Atas']);
        Education::create(['name' => 'Sekolah Menengah Pertama']);
        Education::create(['name' => 'Sekolah Dasar']);
        Education::create(['name' => 'Prasekolah']);
    }
}
