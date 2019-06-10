<?php
namespace App\Http\Controllers\Api\Mobile;
use App\Http\Controllers\Controller;
use TCG\Voyager\Models\Post;
class PostsController extends Controller
{

	public function getAll()
	{
		return Post::where('status', '=', 'PUBLISHED')->get();
	}

}