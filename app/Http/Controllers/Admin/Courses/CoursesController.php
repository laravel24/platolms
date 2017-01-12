<?php 

namespace App\Http\Controllers\Admin\Courses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository as CourseRepository;

class CoursesController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Courses Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(CourseRepository $courseRepo)
	{
		$this->repository = $courseRepo;
		$this->menuTab = 'courses';
	}

	/**
	 * Show the index of Courses.
	 *
	 * @return Response
	 */
	public function index()
	{
		$courses = $this->repository->getCourses();
		$menuTab = $this->menuTab;
		return response()->view('admin.courses.courses.index', compact(['courses', 'menuTab']));
	}

	/**
	 * Show an page to create a Course
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
		$subjects = \App\Models\Subject::pluck('name', 'id');
	    return response()->view('admin.courses.courses.create', compact(['menuTab', 'subjects']));
	}

	/**
	 * Store the newly created Course
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = $this->validate($request, [
        	'title' => 'required',
        	'description' => 'required',
        ]);

        try
        {
        	$newCourse = $this->repository->createCourse($request->all());

        	try{

        		$course = \App\Models\Course::find($newCourse);
	            $course->subjects()->syncWithoutDetaching($request->subjects);

	        } catch(\Exception $exception)
	        {
	            $this->flashErrorAndReturnWithMessage($exception);
	        }

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your course was added!');
        return redirect()->action('Admin\Courses\CoursesController@index');
	}

	/**
	 * Show an individual Course's profile
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$course = $this->repository->getCourse($id);
		$menuTab = $this->menuTab;
		$subjects = \App\Models\Subject::pluck('name', 'id');
		return response()->view('admin.courses.courses.edit', compact(['course', 'menuTab', 'subjects']));
	}

	/**
	 * Update the newly created Course
	 *
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $validator = $this->validate($request, [
        	//
        ]);

        try
        {
        	$updatedCourse = $this->repository->updateCourse($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The course was updated!');
        return redirect()->action('Admin\Courses\CourseController@edit', ['course' => $id]);
	}

	/**
	 * Archive the Course
	 *
	 * @return Boolean
	 */
	public function destroy($id)
	{
        try
        {
        	$this->repository->deleteCourse($id);

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        return response('Excellent!', 200);
	}

}
