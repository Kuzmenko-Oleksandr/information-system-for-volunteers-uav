<?php

namespace App\Http\Controllers\Volunteer\Post;

use App\Models\Category;
use App\Models\Tag;

class CreateController extends BaseController
{
    public function __invoke()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('volunteer.post.create', compact('categories', 'tags'));
    }
}
