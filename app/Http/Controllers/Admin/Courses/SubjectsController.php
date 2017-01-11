<?php 

namespace App\Http\Controllers\Admin\Courses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SubjectRepository as SubjectRepository;

class SubjectsController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Subjects Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(SubjectRepository $subjectRepo)
	{
		$this->repository = $subjectRepo;
		$this->menuTab = 'subjects';
	}

	/**
	 * Show the index of Subjects.
	 *
	 * @return Response
	 */
	public function index()
	{
		$subjects = $this->repository->getSubjects();
		$menuTab = $this->menuTab;
		return response()->view('admin.courses.subjects.index', compact(['subjects', 'menuTab']));
	}

	/**
	 * Show an page to create a Subjects
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
	    return response()->view('admin.courses.subjects.create', compact(['menuTab']));
	}

	/**
	 * Store the newly created Subjects
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = $this->validate($request, [
        	'name' => 'required',
        	'slug' => 'required',
        ]);

        try
        {
        	$newSubject = $this->repository->createSubject($request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your subject was added!');
        return redirect()->action('Admin\Courses\SubjectsController@index');
	}

	/**
	 * Show an individual Subject's profile
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$subject = $this->repository->getSubject($id);
		$menuTab = $this->menuTab;
		return response()->view('admin.courses.subjects.edit', compact(['subject', 'menuTab']));
	}

	/**
	 * Update the newly created Subjects
	 *
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $validator = $this->validate($request, [
        	'name' => 'required',
        	'slug' => 'required',
        ]);

        try
        {
        	$updatedSubject = $this->repository->updateSubject($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The subject was updated!');
        return redirect()->action('Admin\Courses\SubjectsController@edit', ['subject' => $id]);
	}

	/**
	 * Archive the Subject
	 *
	 * @return Boolean
	 */
	public function destroy($id)
	{
        try
        {
        	$this->repository->deleteSubject($id);

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        return response('Excellent!', 200);
	}

}
