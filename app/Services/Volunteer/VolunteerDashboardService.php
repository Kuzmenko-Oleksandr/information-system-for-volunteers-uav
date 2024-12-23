<?php

namespace App\Services\Volunteer;

use App\Models\Post;
use App\Models\GoogleMapMarker;
use Illuminate\Support\Facades\Auth;

class VolunteerDashboardService
{
    public function getDashboardData()
    {
        $data = [];

        $data['postsCount'] = Post::where('user_id', Auth::id())->count();

        $data['likesCount'] = Auth::user()->likedPosts()->count();

        $data['commentsCount'] = Auth::user()->comments()->count();

        $data['mapsCount'] = GoogleMapMarker::where('user_id', Auth::id())->count();

        return $data;
    }
}
