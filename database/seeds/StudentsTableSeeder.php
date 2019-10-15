<?php

use App\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class_id = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
        ];

        $gender = [
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
        ];

        $faker = Factory::create('id_ID');
        for ($i = 0; $i < 200; $i++) {
            $classRandKey = array_rand($class_id);
            $genderRandKey = array_rand($gender);

            Student::create([
                'nisn' => $faker->nik,
                'nis' => $faker->nik,
                'name' => $faker->name,
                'gender' => $gender[$genderRandKey],
                'class_group_id' => $class_id[$classRandKey],
            ]);
        }
    }
}
