<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desc = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $thirdBuilding = App\Models\Building::find(3);

        for ($room = 100; $room < 140; $room++)
        {
            App\Models\Room::create([
                'building_id' => $thirdBuilding->id,
                'title' => $room,
                'desc' => $desc,
                'img' => 'http://placeholder.pics/svg/300x300/DEDEDE/555555/room',
                'address' => $thirdBuilding->address,
                'address_2' => $thirdBuilding->address_2,
                'city' => $thirdBuilding->city,
                'postal' => $thirdBuilding->postal,
                'state' => $thirdBuilding->state,
                'country' => $thirdBuilding->country,
                'timezone' => $thirdBuilding->timezone,
                'phone' => $thirdBuilding->phone,
            ]);
        }

    }
}
