<?php

namespace App\Http\Controllers\Volunteer\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Volunteer\PostService;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, Post $post)
    {
        if (auth()->user()->role === 'volunteer' && $post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'preview_image' => 'nullable|file',
            'main_image' => 'nullable|file',
            'category_id' => 'required|integer|exists:categories,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'nullable|integer|exists:tags,id',
            'visibility' => 'required|string|in:all,registered,admin_volunteer',
            'page' => 'required|string|in:stream,volunteer_organizations,collections',
        ]);

        $this->service->update($data, $post);

        return redirect()->route('volunteer.post.index');
    }
}
