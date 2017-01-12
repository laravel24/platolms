<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$numberOfPeopleToSeed = 30;

    	// Create Users
	    factory(App\Models\User::class, $numberOfPeopleToSeed)->create();

	    // For easy dev tests only
        $dev = App\Models\User::create([
            'id' => $numberOfPeopleToSeed + 1,
            'email' => env('DEV_EMAIL', 'johndoe@mailinator.com'),
            'password' => bcrypt('snuffles'),
            'first' => env('DEV_FIRST', 'John'),
            'last' => env('DEV_LAST', 'Doe'),
            'display_name' => env('DEV_FIRST', 'John') . ' ' . env('DEV_LAST', 'Doe'),
            'bio' => env('DEV_BIO', 'Here is the dev bio'),
            'img' => env('DEV_PIC', 'http://placeholder.pics/svg/300x300/DEDEDE/555555/avatar'),
            'question' => 'What city were you born in?',
            'answer' => 'New York',
	        'address' => '1234 S Madison Square Avenue',
	        'address_2' => 'Apt 343',
	        'city' => 'New York',
	        'postal' => '10004',
	        'state' => 'NY',
	        'country' => 'USA',
	        'timezone' => 'EST',
	        'phone' => '867-5309',
            'remember_token' => str_random(10),
        ]);
    }
}
