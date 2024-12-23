<?php

namespace App\Http\Controllers\Volunteer\Map;

use App\Models\Post;

class CreateController extends BaseController
{
    public function __invoke()
    {
        $posts = Post::where('user_id', auth()->id())->get();
        return view('volunteer.map.create', compact('posts'));
    }
}
