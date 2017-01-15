<?php

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desc = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $courses = Config::get('seed.courses');

        foreach ($courses as $course)
        {
            App\Models\Course::create([
                'subject_id' => $course['subject_id'],
                'level' => $course['level'],
                'number' => $course['number'],
                'title' => $course['title'],
                'slug' => str_slug($course['title'], '-'),
                'sub_title' => $course['sub_title'],
                'description' => $desc,
                'online' => $course['online'],
                'campus' => $course['campus'],
                'options' => json_encode(['other_prerequisites' => $desc, 'public_notes' => $desc, 'internal_notes' => $desc])
            ]);
        }

    }
}
