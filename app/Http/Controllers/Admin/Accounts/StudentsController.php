<?php 

namespace App\Http\Controllers\Admin\Accounts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentsController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Students Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->menuTab = 'students';
	}

	/**
	 * Show the application dashboard to the student.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = \App\Models\User::whereHas(
		    'roles', function($q){
		        $q->where('name', env('STUDENT_LABEL', 'Student'));
		    })->paginate();
		$menuTab = $this->menuTab;
		return response()->view('admin.accounts.users.students', compact(['users', 'menuTab']));
	}

	/**
	 * Show the admin students panel for those students who are soft deleted
	 *
	 * @return Response
	 */
	public function archived()
	{
		$users = \App\Models\User::onlyTrashed()->whereHas(
		    'roles', function($q){
		        $q->where('name', env('STUDENT_LABEL', 'Student'));
		    })->paginate();
		$menuTab = $this->menuTab;
		$title = 'Students';
		return response()->view('admin.accounts.users.archived', compact(['users', 'title', 'menuTab']));
	}


	/**
	 * Show an page to create a student profile
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
		$studentLabel = true;
	    return response()->view('admin.accounts.users.create', compact(['menuTab', 'studentLabel']));
	}

	/**
	 * Store the newly created student
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = $this->validate($request, [
            'first' => 'required|alpha',
            'last' => 'required|alpha',
            'email' => 'required|email|unique:users',
        ]);

        try
        {
        	$newUser = $this->repository->createUser($request->all());

        	if ($newUser)
        	{
				$user = $this->repository->getUser($newUser);
		        $studentRole = \App\Models\Role::where('name', env('STUDENT_LABEL', 'Student'))->first();
				$user->roles()->syncWithoutDetaching([$studentRole->id]);
        	}

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your student was added!');
        return redirect()->action('Admin\Accounts\StudentsController@index');
	}

}
