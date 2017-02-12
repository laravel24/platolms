<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$seedTags = ['events', 'updates', 'media', 'blogs'];

        foreach ($seedTags as $tag)
        {
            App\Models\Tag::create([
                'title' => $tag,
                'slug' => str_slug($tag),
            ]);
        }

    }
}
