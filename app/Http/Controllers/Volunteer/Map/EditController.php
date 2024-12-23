<?php

namespace App\Http\Controllers\Volunteer\Map;

use App\Models\GoogleMapMarker;
use App\Models\Post;

class EditController extends BaseController
{
    public function __invoke(GoogleMapMarker $marker)
    {
        if ($marker->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $posts = Post::where('user_id', auth()->id())->get();
        return view('volunteer.map.edit', compact('marker', 'posts'));
    }
}
