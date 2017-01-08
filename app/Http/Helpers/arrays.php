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


	 