<?php

namespace App\Http\Controllers\Volunteer\Map;

use App\Models\GoogleMapMarker;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    public function __invoke(Request $request, GoogleMapMarker $marker)
    {
        if ($marker->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        $marker->update($data);

        return redirect()->route('volunteer.marker.index');
    }
}
