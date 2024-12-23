<?php

namespace App\Http\Controllers\Volunteer\Post;

use App\Models\Post;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $posts = Post::where('user_id', auth()->id())->get();
        return view('volunteer.post.index', compact('posts'));
    }
}
