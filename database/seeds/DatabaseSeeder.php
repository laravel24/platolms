<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersRolesTableSeeder::class);

        // FE Site

        // Degree Programs
        $this->call(CollegesTableSeeder::class);
        $this->call(DegreesTableSeeder::class);
        $this->call(MajorsTableSeeder::class);
        $this->call(MinorsTableSeeder::class);
        $this->call(MajorsMinorsTableSeeder::class);
        $this->call(SemestersTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(CourseTagsTableSeeder::class);

    }
}
