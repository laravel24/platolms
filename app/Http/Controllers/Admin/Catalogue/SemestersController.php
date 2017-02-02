<?php 

namespace App\Http\Controllers\Admin\Catalogue;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SemesterRepository as SemesterRepository;

class SemestersController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Semesters Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(SemesterRepository $semesterRepo)
	{
		$this->repository = $semesterRepo;
		$this->menuTab = 'semesters';
	}

	/**
	 * Show the index of Semesters.
	 *
	 * @return Response
	 */
	public function index()
	{
		$semesters = \App\Models\Semester::orderBy('start', 'desc')->get();
		$semestersByYear = $semesters->groupBy(function($item,$key) {
			return substr($item['start'], 0, 4);
		});
		$menuTab = $this->menuTab;
		return response()->view('admin.catalogues.semesters.index', compact(['semestersByYear', 'menuTab']));
	}

	/**
	 * Store the newly created Semester
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = $this->validate($request, [
        	'title' => 'required',
        	'start' => 'required',
        	'end' => 'required',
        ]);

        try
        {
        	$newSemester = $this->repository->createSemester($request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your semester was added!');
        return redirect()->action('Admin\Catalogue\SemestersController@index');
	}

	/**
	 * Show an individual Semester's profile
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$editSemester = $this->repository->getSemester($id);
		$menuTab = $this->menuTab;
		$semesters = \App\Models\Semester::orderBy('start', 'desc')->get();
		$semestersByYear = $semesters->groupBy(function($item,$key) {
			return substr($item['start'], 0, 4);
		});
		return response()->view('admin.catalogues.semesters.index', compact(['semestersByYear', 'editSemester', 'menuTab']));
	}

	/**
	 * Update the newly created Semester
	 *
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $validator = $this->validate($request, [
        	'title' => 'required',
        	'start' => 'required',
        	'end' => 'required',
        ]);

        try
        {
        	$updatedSemester = $this->repository->updateSemester($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The semester was updated!');
        return redirect()->action('Admin\Catalogue\SemestersController@edit', ['semester' => $id]);
	}

	/**
	 * Archive the Semester
	 *
	 * @return Boolean
	 */
	public function destroy($id)
	{
        try
        {
        	$this->repository->deleteSemester($id);

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        return response('Excellent!', 200);
	}

}
