<?php 

namespace App\Http\Controllers\Admin\Resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BuildingRepository as BuildingRepository;

class BuildingsController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Buildings Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(BuildingRepository $buildingRepo)
	{
		$this->repository = $buildingRepo;
		$this->menuTab = 'buildings';
	}

	/**
	 * Show the index of Buildings.
	 *
	 * @return Response
	 */
	public function index()
	{
		$buildings = $this->repository->getBuildings();
		$menuTab = $this->menuTab;
		return response()->view('admin.resources.buildings.index', compact(['buildings', 'menuTab']));
	}

	/**
	 * Show an page to create a Building
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
	    return response()->view('admin.resources.buildings.create', compact(['menuTab']));
	}

	/**
	 * Store the newly created Building
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
        	$newBuilding = $this->repository->createBuilding($request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your building was added!');
        return redirect()->action('Admin\Resources\BuildingsController@index');
	}

	/**
	 * Show an individual Building's profile
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$building = $this->repository->getBuilding($id);
		$menuTab = $this->menuTab;
		return response()->view('admin.resources.buildings.edit', compact(['building', 'menuTab']));
	}

	/**
	 * Update the newly created Building
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
        	$updatedBuilding = $this->repository->updateBuilding($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The building was updated!');
        return redirect()->action('Admin\Resources\BuildingsController@edit', ['building' => $id]);
	}

	/**
	 * Archive the Building
	 *
	 * @return Boolean
	 */
	public function destroy($id)
	{
        try
        {
        	$this->repository->deleteBuilding($id);

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        return response('Excellent!', 200);
	}

}
