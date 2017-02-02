<?php 

namespace App\Http\Controllers\Admin\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository as PostRepository;

class PostsController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Posts Controller
	|--------------------------------------------------------------------------
	*/

	public function __construct(PostRepository $postRepo)
	{
		$this->repository = $postRepo;
		$this->menuTab = 'posts';
	}

	/**
	 * Show the posts panel
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$menuTab = $this->menuTab;

        if (is_null($request->cat))
        {
			$posts = $this->repository->paginatePosts([], 20, false);
        } else {
			$posts = \App\Models\Post::whereHas('categories', function($q){
		        	$q->where('name', $request->cat);
		    	})->paginate();
        }

		return response()->view('admin.site.posts.index', compact(['posts', 'menuTab', 'request']));
	}

	/**
	 * Show an page to create a post
	 *
	 * @return Response
	 */
	public function create()
	{
		$menuTab = $this->menuTab;
		$tags = \App\Models\Tag::get()->toJson();
		$categories = \App\Models\Category::get()->toJson();
	    return response()->view('admin.site.posts.create', compact(['menuTab', 'tags', 'categories']));
	}

	/**
	 * Store the newly created post
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $validator = $this->validate($request, [
            'title' => 'required',
        ]);

    	// send to the post repository
        try
        {
        	$newPost = $this->repository->createPost($request->all());

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your post was added!');
        return redirect()->action('Admin\Accounts\PostsController@index');
	}

}
