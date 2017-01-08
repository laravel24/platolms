<?php 

namespace App\Http\Controllers\Admin\Catalogue;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CollegeRepository as CollegeRepository;

class CollegesController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Colleges Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(CollegeRepository $collegeRepo)
	{
		$this->repository = $collegeRepo;
		$this->menuTab = 'colleges';
	}

	/**
	 * Show the index of colleges.
	 *
	 * @return Response
	 */
	public function index()
	{
		$colleges = $this->repository->getColleges();
		$menuTab = $this->menuTab;
		return response()->view('admin.catalogues.colleges.index', compact(['colleges', 'menuTab']));
	}

	/**
	 * Show an page to create a college
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
		$admins = \App\Models\User::whereHas('roles', function($q){
		        	$q->where('name', '!=', env('STUDENT_LABEL', 'Student'));
		    	})->pluck('display_name', 'id');
	    return response()->view('admin.catalogues.colleges.create', compact(['menuTab', 'admins']));
	}

	/**
	 * Store the newly created college
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = $this->validate($request, [
        	'name' => 'required',
        	'slug' => 'required',
        	'description' => 'required',
        	'contact_id' => 'required',
        ]);

        try
        {
        	$newCollege = $this->repository->createCollege($request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your college was added!');
        return redirect()->action('Admin\Catalogue\CollegesController@index');
	}

	/**
	 * Show an page to create a college
	 *
	 * @return Response
	 */
	public function edit($collegeId)
	{
		$menuTab = $this->menuTab;
		$admins = \App\Models\User::whereHas('roles', function($q){
		        	$q->where('name', '!=', env('STUDENT_LABEL', 'Student'));
		    	})->pluck('display_name', 'id');
		$college = $this->repository->getCollege($collegeId);
	    return response()->view('admin.catalogues.colleges.edit', compact(['menuTab', 'admins', 'college']));
	}

	/**
	 * Update the newly created college
	 *
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $validator = $this->validate($request, [
        	'name' => 'required',
        	'slug' => 'required',
        	'description' => 'required',
        	'contact_id' => 'required',
        ]);

        try
        {
        	$updatedCollege = $this->repository->updateCollege($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The college was updated!');
        return redirect()->action('Admin\Catalogue\CollegesController@edit', $id);
	}

	/**
	 * Archive the college
	 *
	 * @return Boolean
	 */
	public function destroy($id)
	{
        try
        {
        	$this->repository->deleteCollege($id);

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        return response('Excellent!', 200);
	}

}
