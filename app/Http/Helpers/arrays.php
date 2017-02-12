<?php

/*
|--------------------------------------------------------------------------
| Form Helpers
|--------------------------------------------------------------------------
*/

	/**
	 * Get the roles used
	 *
	 * @devtodo: Fix the pulling of roles from either the settings or the database -> but not both
	 * @return string
	 */
	 function getRoles()
	 {
		return [
			'1' => env('SUPER_ADMIN_LABEL', 'Super Admin'), 
            '2' => env('ADMIN_LABEL', 'Admin'), 
            '3' => env('EDITOR_LABEL', 'Editor'), 
            '4' => env('INSTRUCTOR_LABEL', 'Instructor'), 
            '5' => env('STUDENT_LABEL', 'Student')
		];	 	
	 }

	/**
	 * Get the roles used as string
	 *
	 * @return string
	 */
	 function getRolesAsStrings()
	 {
	 	$roles = getRoles();
		return implode(",", $roles);
	 }

	/**
	 * Get the types of blogs we can have
	 *
	 * @return string
	 */
	 function getPostTypes()
	 {
		return collect([
			['id' => 1, 'title' => 'standard'],
			['id' => 2, 'title' => 'gallery'],
			['id' => 3, 'title' => 'image'],
			['id' => 4, 'title' => 'video'],
			['id' => 5, 'title' => 'audio'],
		]);
	 }


	/**
	 * Get a list of months
	 *
	 * @return string
	 */
	 function getMonths()
	 {
		return collect([
			['id' => 1, 'title' => 'Jan'],
			['id' => 2, 'title' => 'Feb'],
			['id' => 3, 'title' => 'Mar'],
			['id' => 4, 'title' => 'Apr'],
			['id' => 5, 'title' => 'May'],
			['id' => 6, 'title' => 'Jun'],
			['id' => 7, 'title' => 'Jul'],
			['id' => 8, 'title' => 'Aug'],
			['id' => 9, 'title' => 'Sep'],
			['id' => 10, 'title' => 'Oct'],
			['id' => 11, 'title' => 'Nov'],
			['id' => 12, 'title' => 'Dec'],
		]);
	 }	 


	 