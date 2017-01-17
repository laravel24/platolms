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
		$tags = \App\Models\CourseTag::pluck('name', 'id');
	    return response()->view('admin.courses.courses.create', compact(['menuTab', 'subjects', 'tags']));
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
        	'slug' => 'required',
        	'level' => 'required',
        	'number' => 'required',
        	'subject_id' => 'required',
        	'description' => 'required',
        ]);

        try
        {
        	$newCourse = $this->repository->createCourse($request->all());

        	try{

        		$course = \App\Models\Course::find($newCourse);
	            $course->tags()->syncWithoutDetaching($request->tags);

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
		$tags = \App\Models\CourseTag::pluck('name', 'id');
		return response()->view('admin.courses.courses.edit', compact(['course', 'menuTab', 'subjects', 'tags']));
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
        return redirect()->action('Admin\Courses\CoursesController@edit', ['course' => $id]);
	}

	/**
	 * Get the options page
	 *
	 * @return Response
	 */
	public function options($id)
	{
		$course = $this->repository->getCourse($id);
		$menuTab = $this->menuTab;
		$courses = $this->repository->getCourses();
		$coursesAsArray = [];
		foreach ($courses as $item)
		{
			if ($item->id != $id)
			{
				$coursesAsArray[$item->id] = $item->subject->abbr . $item->number . ': ' . $item->title;
			}
		}
		$courseOptions = collect($this->getExtraCourseOptions());

		if ($course->options)
		{
			$courseOptions = json_decode($course->options);
			$courseOptions = collect($courseOptions);
		}

		return response()->view('admin.courses.courses.options', compact(['course', 'menuTab', 'coursesAsArray', 'courseOptions']));
	}

	/**
	 * Update the course options 
	 *
	 * @return Response
	 */
	public function updateOptions(Request $request, $id)
	{
        $validator = $this->validate($request, [
        	//
        ]);

        try
        {

        	if ($request->prereqs)
        	{
	    		$course = \App\Models\Course::find($id);
	            $course->prerequisites()->syncWithoutDetaching($request->prereqs);
        	}

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        try
        {

        	$courseOptions = [];
        	$options = $this->getExtraCourseOptions();
        	foreach ($options as $key => $value)
        	{
	        	if ($request->$key)
	        	{
	        		$courseOptions[$key] = $request->$key;
	        	}
        	}

    		$courseOptions = json_encode($courseOptions);
			\App\Models\Course::where('id', $id)
			          ->update(['options' => $courseOptions]);

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The course options were updated!');
        return redirect()->action('Admin\Courses\CoursesController@options', ['course' => $id]);   		
	}

	/**
	 * Get the scheduling page
	 *
	 * @return Response
	 */
	public function scheduling($id)
	{
		$course = $this->repository->getCourse($id);
		$menuTab = $this->menuTab;
		$semesters = \App\Models\Semester::pluck('title', 'id');
		$campuses = \App\Models\Campus::get();
		$instructors = \App\Models\User::whereHas('roles', function($q){
		        	$q->where('name', '=', env('INSTRUCTOR_LABEL', 'Instructor'));
		    	})->get();
		return response()->view('admin.courses.courses.scheduling', compact(['course', 'menuTab', 'semesters', 'campuses', 'instructors']));
	}

	/**
	 * Update the course scheduling 
	 *
	 * @return Response
	 */
	public function updateScheduling(Request $request, $id)
	{
		dd($request);
	}
	
	/**
	 * Get the revisions page
	 *
	 * @return Response
	 */
	public function revisions($id)
	{
		$course = $this->repository->getCourse($id);
		$menuTab = $this->menuTab;
		return response()->view('admin.courses.courses.revisions', compact(['course', 'menuTab']));
	}

	/**
	 * Update the course revisions 
	 *
	 * @return Response
	 */
	public function updateRevisions(Request $request, $id)
	{
		dd($request);
	}	

	/**
	 * Get the files page
	 *
	 * @return Response
	 */
	public function files($id)
	{
		$course = $this->repository->getCourse($id);
		$menuTab = $this->menuTab;
		return response()->view('admin.courses.courses.files', compact(['course', 'menuTab']));
	}

	/**
	 * Update the course files 
	 *
	 * @return Response
	 */
	public function updateFiles(Request $request, $id)
	{
		dd($request);
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

	public function getExtraCourseOptions()
	{
		return ['other_prerequisites' => '', 'public_notes' => '', 'internal_notes' => ''];
	}

}
