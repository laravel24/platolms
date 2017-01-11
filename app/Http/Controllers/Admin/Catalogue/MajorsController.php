<?php 

namespace App\Http\Controllers\Admin\Catalogue;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MajorRepository as MajorRepository;

class MajorsController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Majors Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(MajorRepository $majorRepo)
	{
		$this->repository = $majorRepo;
		$this->menuTab = 'majors';
		$this->title = 'Major';
	}

	/**
	 * Show the index of majors.
	 *
	 * @return Response
	 */
	public function index()
	{
		$majors = $this->repository->paginateMajors([], 30, false);
		$menuTab = $this->menuTab;
		$title = $this->title;
		return response()->view('admin.catalogues.majors.index', compact(['majors', 'menuTab', 'title']));
	}

	/**
	 * Show an page to create a major
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
		$title = $this->title;
		$colleges = \App\Models\College::get()->pluck('name', 'id');
		$degreeTypes = \App\Models\Degree::get()->pluck('name', 'id');
		$minors = \App\Models\Minor::get()->pluck('name', 'id');
	    return response()->view('admin.catalogues.majors.create', compact(['menuTab', 'title', 'colleges', 'degreeTypes', 'minors']));
	}

	/**
	 * Store the newly created major
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = $this->validate($request, [
        	'name' => 'required',
        	'slug' => 'required',
        	'degree_id' => 'required',
        	'college_id' => 'required',
        	'hours' => 'required',
        	'description' => 'required',
        ]);

        try
        {
        	$newMajor = $this->repository->createMajor($request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your major was added!');
        return redirect()->action('Admin\Catalogue\MajorsController@index');
	}

	/**
	 * Show an individual major's profile
	 *
	 * @return Response
	 */
	public function edit($majorId)
	{
		$major = $this->repository->getMajor($majorId);
		$menuTab = $this->menuTab;
		$colleges = \App\Models\College::get()->pluck('name', 'id');
		$degreeTypes = \App\Models\Degree::get()->pluck('name', 'id');
		$minors = \App\Models\Minor::get()->pluck('name', 'id');
		return response()->view('admin.catalogues.majors.edit', compact(['major', 'menuTab', 'colleges', 'degreeTypes', 'minors']));
	}

	/**
	 * Update the newly created major
	 *
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $validator = $this->validate($request, [
        	'name' => 'required',
        	'slug' => 'required',
        	'degree_id' => 'required',
        	'college_id' => 'required',
        	'hours' => 'required',
        	'description' => 'required',
        ]);

        try
        {
        	$updatedMajor = $this->repository->updateMajor($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The major was updated!');
        return redirect()->action('Admin\Catalogue\MajorsController@edit', ['major' => $id]);
	}

	/**
	 * Archive the major
	 *
	 * @return Boolean
	 */
	public function destroy($id)
	{
        try
        {
        	$this->repository->deleteMajor($id);

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        return response('Excellent!', 200);
	}

}
