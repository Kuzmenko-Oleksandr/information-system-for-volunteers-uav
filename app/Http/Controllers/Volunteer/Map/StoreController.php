<?php

namespace App\Http\Controllers\Volunteer\Map;

use App\Models\GoogleMapMarker;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'description' => 'required|string',
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        $data['user_id'] = auth()->id();

        GoogleMapMarker::create($data);

        return redirect()->route('volunteer.marker.index');
    }
}
