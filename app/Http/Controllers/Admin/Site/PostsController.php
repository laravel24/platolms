<?php 

namespace App\Http\Controllers\Admin\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository as PostRepository;

use App\Services\Utility\ResizeImage as ResizeImage;
use App\Services\Utility\UploadFile as UploadFile;

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
		$postTypes = getPostTypes()->toJson();
		$months = getMonths()->toJson();
		$authors = \App\Models\User::whereHas('roles', function($q){
		        	$q->where('name', '=', env('ADMIN_LABEL', 'Admin'))->orWhere('name', '=', env('EDITOR_LABEL', 'Editor'))->orWhere('name', '=', env('SUPER_ADMIN_LABEL', 'Super Admin'));
		    	})->get()->toJson();
		// dd($authors);
	    return response()->view('admin.site.posts.create', compact(['menuTab', 'tags', 'categories', 'postTypes', 'months', 'authors']));
	}

	/**
	 * Store the newly created post
	 *
	 * @return Response
	 */
	public function store(Request $request, UploadFile $upload)
	{
        $validator = $this->validate($request, [
            'title' => 'required',
            'slug' => 'required',
        ]);

    	// send to the post repository
        try
        {
        	$day = date('d');
    		$month = date('m');
    		$year = date('Y');
    		$savedFile = null;
    		$postAuthor = \Auth::user()->id;
    		$postType = 1;

        	// format the date of the post
        	if (isset($request->day))
        	{
        		$day = $request->day;
        		if (isset($request->month) && ($request->month != ''))
        		{
        			$month = $request->month;
        		}

        		if (isset($request->year) && ($request->year != ''))
        		{
        			$year = $request->year;
        		}
        	}

        	// save the file
        	if (($request->featured_image) && ($request->featured_image != ''))
        	{
		    	$savedFile = $upload->uploadSiteContentImage('posts/' . $year . '/' . $month . '/' . $day . '/', $request->featured_image);
        	}

        	if (($request->post_type) && ($request->post_type != ''))
        	{
        		$postTypeAsArray = collect(json_decode($request->post_type))->toArray();
        		$postType = $postTypeAsArray['id'];
        	}

        	if (($request->post_author) && ($request->post_author != ''))
        	{
        		$postAuthorAsArray = collect(json_decode($request->post_author))->toArray();
        		$postAuthor = $postAuthorAsArray['id'];
        	}

			$newPost = $this->repository->createPost([
				'title' => $request->title,
				'author' => $postAuthor,
				'slug' => $request->slug,
				'scheduled_for' => $year . '-' . $month . '-' . $day,
				'content' => $request->content,
				'img' => $savedFile,
				'type' => $postType,
			]);

			$post = $this->repository->getPost($newPost);

        	// attach the tags
        	if (($request->post_tags) && ($request->post_tags != ''))
        	{
        		$postTagsAsArray = collect(json_decode($request->post_tags))->toArray();
        		$tags = [];
        		foreach ($postTagsAsArray as $tag)
        		{
        			$tagAsArray = collect($tag)->toArray();
        			$tags[] = $tagAsArray['id'];
        		}
        		$post->tags()->sync($tags);
        	}

        	// attach the categories
        	if (($request->post_categories) && ($request->post_categories != ''))
        	{
        		$postCatsAsArray = collect(json_decode($request->post_categories))->toArray();
        		$cats = [];
        		foreach ($postCatsAsArray as $cat)
        		{
        			$catAsArray = collect($cat)->toArray();
        			$cats[] = $catAsArray['id'];
        		}
        		$post->categories()->sync($cats);
        	}

        } catch(\Exception $exception)
        {
            $this->flashErrorAndReturnWithMessage($exception);
        }

        // returns back with success message
        flash()->success('Your post was added!');
        return redirect()->action('Admin\Site\PostsController@index');
	}

}
