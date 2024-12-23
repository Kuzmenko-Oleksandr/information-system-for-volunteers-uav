<?php

namespace App\Http\Controllers\Post;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke(Request $request, $page = 'stream')
    {
        $categoryIds = $request->input('categories', []);
        $tagIds = $request->input('tags', []);

        $posts = $this->postService->getLatestPostsByPage($page, 6, $categoryIds, $tagIds);
        $randomPosts = $this->postService->getRandomPosts();
        $likedPosts = $this->postService->getLikedPosts();

        $categories = Category::all();
        $tags = Tag::all();

        return view('post.index', compact('posts', 'randomPosts', 'likedPosts', 'categories', 'tags', 'page'));
    }
}

