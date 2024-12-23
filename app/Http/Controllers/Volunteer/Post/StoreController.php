<?php

namespace App\Http\Controllers\Volunteer\Post;

use App\Http\Controllers\Controller;
use App\Services\Volunteer\PostService;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'tag_ids' => 'array',
            'tag_ids.*' => 'integer|exists:tags,id',
            'preview_image' => 'required|image',
            'main_image' => 'required|image',
            'visibility' => 'required|string|in:all,registered,admin_volunteer',
            'page' => 'required|string|in:stream,volunteer_organizations,collections',
        ]);

        $this->service->store($data);

        return redirect()->route('volunteer.post.index');
    }
}
