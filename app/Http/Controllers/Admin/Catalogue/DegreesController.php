<?php 

namespace App\Http\Controllers\Admin\Catalogue;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DegreeRepository as DegreeRepository;

class DegreesController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Degrees Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(DegreeRepository $degreeRepo)
	{
		$this->repository = $degreeRepo;
		$this->menuTab = 'degrees';
	}

	/**
	 * Show the index of degrees.
	 *
	 * @return Response
	 */
	public function index()
	{
		$degrees = $this->repository->getDegrees();
		$menuTab = $this->menuTab;
		return response()->view('admin.catalogues.degrees.index', compact(['degrees', 'menuTab']));
	}

	/**
	 * Show an page to create a degree
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
	    return response()->view('admin.catalogues.degrees.create', compact(['menuTab']));
	}

	/**
	 * Store the newly created degree
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = $this->validate($request, [
        	'name' => 'required',
        	'slug' => 'required',
        	'description' => 'required',
        ]);

        try
        {
        	$newDegree = $this->repository->createDegree($request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your degree was added!');
        return redirect()->action('Admin\Catalogue\DegreesController@index');
	}

	/**
	 * Show an page to create a degree
	 *
	 * @return Response
	 */
	public function edit($degreeId)
	{
		$menuTab = $this->menuTab;
		$degree = $this->repository->getDegree($degreeId);
	    return response()->view('admin.catalogues.degrees.edit', compact(['menuTab', 'admins', 'degree']));
	}

	/**
	 * Update the newly created degree
	 *
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $validator = $this->validate($request, [
        	'name' => 'required',
        	'slug' => 'required',
        	'description' => 'required',
        ]);

        try
        {
        	$updatedDegree = $this->repository->updateDegree($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The degree was updated!');
        return redirect()->action('Admin\Catalogue\DegreesController@edit', $id);
	}

	/**
	 * Archive the degree
	 *
	 * @return Boolean
	 */
	public function destroy($id)
	{
        try
        {
        	$this->repository->deleteDegree($id);

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        return response('Excellent!', 200);
	}

}
