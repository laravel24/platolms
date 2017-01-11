<?php

use Illuminate\Database\Seeder;

class SemestersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Semester::create([
            'title' => 'Winter I',
            'start' => '2017-01-10',
            'end' => '2017-03-15',
        ]);

        App\Models\Semester::create([
            'title' => 'Winter II',
            'start' => '2017-03-17',
            'end' => '2017-05-28',
        ]);

        App\Models\Semester::create([
            'title' => 'Spring I',
            'start' => '2017-05-28',
            'end' => '2017-06-25',
        ]);

        App\Models\Semester::create([
            'title' => 'Summer I',
            'start' => '2017-06-25',
            'end' => '2017-08-10',
        ]);

        App\Models\Semester::create([
            'title' => 'Fall I',
            'start' => '2017-08-10',
            'end' => '2017-10-15',
        ]);

        App\Models\Semester::create([
            'title' => 'Fall II',
            'start' => '2017-10-10',
            'end' => '2017-12-15',
        ]);
    }
}
