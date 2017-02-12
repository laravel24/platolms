<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$seedCategories = ['General', 'Notes From the President', 'Student Affairs', 'Calendar'];

        foreach ($seedCategories as $category)
        {
            App\Models\Category::create([
                'title' => $category,
                'slug' => str_slug($category),
            ]);
        }

    }
}
