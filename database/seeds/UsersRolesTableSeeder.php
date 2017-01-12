<?php

use Illuminate\Database\Seeder;

class UsersRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $studentRole = App\Models\Role::where('name', env('STUDENT_LABEL', 'Student'))->first();

    	// Find Users
	    $users = App\Models\User::get();

        foreach ($users as $user)
        {
            $user->roles()->syncWithoutDetaching([$studentRole->id]);

            // For easy dev tests only
            if ($user->email == env('DEV_EMAIL'))
            {
                $user->roles()->syncWithoutDetaching([1]);
            }
        }
    }
}
