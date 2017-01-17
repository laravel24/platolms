<?php 

namespace App\Http\Controllers\Admin\Resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CampusRepository as CampusRepository;

class CampusesController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Campuses Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(CampusRepository $campusRepo)
	{
		$this->repository = $campusRepo;
		$this->menuTab = 'campuses';
	}

	/**
	 * Show the index of Campuses.
	 *
	 * @return Response
	 */
	public function index()
	{
		$campuses = $this->repository->getCampuses();
		$menuTab = $this->menuTab;
		return response()->view('admin.resources.campuses.index', compact(['campuses', 'menuTab']));
	}

	/**
	 * Show an page to create a Campus
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
	    return response()->view('admin.resources.campuses.create', compact(['menuTab']));
	}

	/**
	 * Store the newly created Campus
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = $this->validate($request, [
        	//
        ]);

        try
        {
        	$newCampus = $this->repository->createCampus($request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your campus was added!');
        return redirect()->action('Admin\Resources\CampusesController@index');
	}

	/**
	 * Show an individual Campus's profile
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$asset = $this->repository->getAsset($id);
		$menuTab = $this->menuTab;
		return response()->view('admin.resources.campuses.edit', compact(['campus', 'menuTab']));
	}

	/**
	 * Update the newly created Campus
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
        	$updatedCampus = $this->repository->updateCampus($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The campus was updated!');
        return redirect()->action('Admin\Resources\CampusesController@edit', ['campus' => $id]);
	}

	/**
	 * Archive the Campus
	 *
	 * @return Boolean
	 */
	public function destroy($id)
	{
        try
        {
        	$this->repository->deleteCampus($id);

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        return response('Excellent!', 200);
	}

	public function getBuildings(Request $request)
	{
        $validator = $this->validate($request, [
        	'campus' => 'required',
        ]);

        return response()->json(['success' => true, 'campus' => $request->campus]);
	}


}
