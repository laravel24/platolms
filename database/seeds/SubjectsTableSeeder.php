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
        $names = Config::get('academics.subjects');

        foreach ($names as $name)
        {
            App\Models\Subject::create([
                'name' => $name,
                'slug' => str_slug($name, '-'),
            ]);
        }

    }
}
