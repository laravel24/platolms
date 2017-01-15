<?php

use Illuminate\Database\Seeder;

class CampusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desc = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $campuses = Config::get('seed.campuses');

        foreach ($campuses as $campus)
        {
            App\Models\Campus::create([
                'title' => $campus['title'],
                'desc' => $desc,
                'img' => 'http://placeholder.pics/svg/300x300/DEDEDE/555555/campus',
                'address' => $campus['address'],
                'address_2' => $campus['address_2'],
                'city' => $campus['city'],
                'postal' => $campus['postal'],
                'state' => $campus['state'],
                'country' => $campus['country'],
                'timezone' => $campus['timezone'],
                'phone' => $campus['phone'],
            ]);
        }

    }
}
