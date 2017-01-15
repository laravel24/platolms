<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = Config::get('seed.subjects');

        foreach ($names as $key => $value)
        {
            App\Models\Subject::create([
                'name' => $key,
                'abbr' => $value,
                'slug' => str_slug($key, '-'),
            ]);
        }

    }
}
