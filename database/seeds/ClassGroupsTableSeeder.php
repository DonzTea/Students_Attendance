<?php

use Illuminate\Database\Seeder;
use App\ClassGroup;
use App\SchoolYear;

class ClassGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 6; $i++) {
            $kelas = $i + 1;
            $class = ClassGroup::create([
                'name' => 'Kelas ' . $kelas,
            ]);

            $class->schoolYears()->attach(SchoolYear::find(1));
        }
    }
}
