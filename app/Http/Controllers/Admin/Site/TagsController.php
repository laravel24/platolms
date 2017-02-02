<?php 

namespace App\Http\Controllers\Admin\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TagRepository as TagRepository;

class TagsController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Categories Controller
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(TagRepository $tagRepo)
	{
		$this->repository = $tagRepo;
		$this->menuTab = 'tags';
	}

	/**
	 * Show the tags panel
	 *
	 * @return Response
	 */
	public function index()
	{
		$menuTab = $this->menuTab;
		$tags = $this->repository->getTags();
		return response()->view('admin.site.tags.index', compact(['tags', 'menuTab']));
	}

	/**
	 * Show the page to create a tag
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$menuTab = $this->menuTab;
	    return response()->view('admin.site.tags.create', compact(['menuTab', 'request']));
	}

	/**
	 * Store the newly created tag
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

        $validator = $this->validate($request, [
            'title' => 'required',
            'slug' => 'required',
        ]);

    	// send to the tag repository
        try
        {
        	$newTag = $this->repository->createTag($request->all());

        } catch(\Exception $exception)
        {
	        return response('There was a problem with this request', 500);
        }

        // returns back with success message
        return response()->json(['success' => true, 'tag' => $newTag]);
	}

	/**
	 * Show an individual Tag's profile
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$tag = $this->repository->getTag($id);
		$menuTab = $this->menuTab;
		return response()->view('admin.site.tags.edit', compact(['tag', 'menuTab']));
	}

	/**
	 * Update the tag
	 *
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        $validator = $this->validate($request, [
            'title' => 'required',
        ]);

        try
        {
        	$updatedTag = $this->repository->updateTag($id, $request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('The tag was updated!');
        return redirect()->action('Admin\Site\TagsController@edit', ['tag' => $id]);
	}

}
