<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(SchoolYearsTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(ReligionsTableSeeder::class);
        $this->call(EducationsTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(ClassGroupsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
    }
}
