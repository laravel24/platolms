<?php

use Illuminate\Database\Seeder;

class MajorsMinorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Find Majors
	    $majors = App\Models\Major::get();

        foreach ($majors as $major)
        {
            $major->minors()->syncWithoutDetaching([rand(1,129)]);
        }
    }
}
