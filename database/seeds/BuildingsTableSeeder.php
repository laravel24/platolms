<?php

use Illuminate\Database\Seeder;

class BuildingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desc = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $buildings = Config::get('seed.buildings');
        $thirdCampus = App\Models\Campus::find(3);

        foreach ($buildings as $building)
        {
            App\Models\Building::create([
                'campus_id' => $thirdCampus->id,
                'title' => $building,
                'desc' => $desc,
                'img' => 'http://placeholder.pics/svg/300x300/DEDEDE/555555/building',
                'address' => $thirdCampus->address,
                'address_2' => $thirdCampus->address_2,
                'city' => $thirdCampus->city,
                'postal' => $thirdCampus->postal,
                'state' => $thirdCampus->state,
                'country' => $thirdCampus->country,
                'timezone' => $thirdCampus->timezone,
                'phone' => $thirdCampus->phone,
            ]);
        }

    }
}
