<?php

use Illuminate\Database\Seeder;

class CollegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desc = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $names = Config::get('seed.colleges');
        $admin = App\Models\User::where('email', env('DEV_EMAIL'))->first();

        foreach ($names as $name)
        {
            App\Models\College::create([
                'contact_id' => $admin->id,
                'name' => $name,
                'slug' => str_slug($name, '-'),
                'description' => $desc,
            ]);
        }

    }
}
