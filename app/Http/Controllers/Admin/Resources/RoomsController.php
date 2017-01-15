<?php 

namespace App\Http\Controllers\Admin\Resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoomRepository as RoomRepository;

class RoomsController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Rooms Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(RoomRepository $roomRepo)
	{
		$this->repository = $roomRepo;
		$this->menuTab = 'rooms';
	}

	/**
	 * Show the index of rooms.
	 *
	 * @return Response
	 */
	public function index()
	{
		$rooms = $this->repository->getRooms();
		$menuTab = $this->menuTab;
		return response()->view('admin.resources.rooms.index', compact(['rooms', 'menuTab']));
	}

	/**
	 * Show an page to create a room
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
	    return response()->view('admin.resources.rooms.create', compact(['menuTab']));
	}

	/**
	 * Store the newly created room
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
        	$newRoom = $this->repository->createRoom($request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your room was added!');
        return redirect()->action('Admin\Resources\RoomsController@index');
	}

	/**
	 * Show an individual room's profile
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$room = $this->repository->getRoom($id);
		$menuTab = $this->menuTab;
		return response()->view('admin.resources.rooms.edit', compact(['room', 'menuTab']));
	}

	/**
	 * Update the newly created room
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
        	$updatedRoom = $this->repository->updateRoom($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The room was updated!');
        return redirect()->action('Admin\Resources\RoomsController@edit', ['room' => $id]);
	}

	/**
	 * Archive the room
	 *
	 * @return Boolean
	 */
	public function destroy($id)
	{
        try
        {
        	$this->repository->deleteRoom($id);

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        return response('Excellent!', 200);
	}

}
