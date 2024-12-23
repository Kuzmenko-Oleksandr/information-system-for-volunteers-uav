<?php

namespace App\Http\Controllers\Volunteer\Post;

use App\Models\Post;

class ShowController extends BaseController
{
    public function __invoke(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        return view('volunteer.post.show', compact('post'));
    }
}
