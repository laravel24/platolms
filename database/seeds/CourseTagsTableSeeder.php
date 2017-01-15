<?php

use Illuminate\Database\Seeder;

class CourseTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = Config::get('seed.tags');

        foreach ($names as $name)
        {
            App\Models\CourseTag::create([
                'name' => $name,
                'slug' => str_slug($name, '-'),
            ]);
        }

    }
}
