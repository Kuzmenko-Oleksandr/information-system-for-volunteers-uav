<?php

namespace App\Http\Controllers\Volunteer\Post;

use App\Models\Post;
use Illuminate\Http\Request;

class DeleteController extends BaseController
{
    public function __invoke(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();
        return redirect()->route('volunteer.post.index');
    }
}
