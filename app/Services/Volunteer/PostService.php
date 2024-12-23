<?php

namespace App\Services\Volunteer;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function store($data)
    {
        try {
            DB::beginTransaction();

            $tag_ids = $data['tag_ids'] ?? null;
            unset($data['tag_ids']);

            if (isset($data['preview_image'])) {
                $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
            }
            if (isset($data['main_image'])) {
                $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
            }

            $data['user_id'] = auth()->id();

            $post = Post::create($data);

            if ($tag_ids) {
                $post->tags()->attach($tag_ids);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, 'Error creating post');
        }

        return $post;
    }

    public function update($data, $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        try {
            DB::beginTransaction();

            $tag_ids = $data['tag_ids'] ?? null;
            unset($data['tag_ids']);

            if (isset($data['preview_image'])) {
                $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
            }
            if (isset($data['main_image'])) {
                $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
            }

            $post->update($data);

            if ($tag_ids) {
                $post->tags()->sync($tag_ids);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, 'Error updating post');
        }

        return $post;
    }
}
