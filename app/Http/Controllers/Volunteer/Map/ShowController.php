<?php

namespace App\Http\Controllers\Volunteer\Map;

use App\Models\GoogleMapMarker;

class ShowController extends BaseController
{
    public function __invoke(GoogleMapMarker $marker)
    {
        if ($marker->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        return view('volunteer.map.show', compact('marker'));
    }
}
