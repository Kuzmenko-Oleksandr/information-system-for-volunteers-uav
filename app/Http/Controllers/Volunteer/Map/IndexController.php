<?php

namespace App\Http\Controllers\Volunteer\Map;

use App\Models\GoogleMapMarker;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $markers = GoogleMapMarker::where('user_id', auth()->id())->get();
        $posts = Post::where('user_id', Auth::id())->get();
        return view('volunteer.map.index', compact('markers', 'posts'));
    }
}
