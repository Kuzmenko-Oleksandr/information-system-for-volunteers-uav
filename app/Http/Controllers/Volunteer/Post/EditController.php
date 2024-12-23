<?php

namespace App\Http\Controllers\Volunteer\Post;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class EditController extends BaseController
{
    public function __invoke(Post $post)
    {
        if (auth()->user()->role === 'volunteer' && $post->user_id !== auth()->id()) {
            abort(403, 'У вас нет прав для редактирования этого поста');
        }

        $categories = Category::all();
        $tags = Tag::all();
        return view('volunteer.post.edit', compact('post', 'categories', 'tags'));
    }
}
