<?php

namespace App\Http\Controllers\Volunteer\Map;

use App\Models\GoogleMapMarker;

class DeleteController extends BaseController
{
    public function __invoke(GoogleMapMarker $marker)
    {
        if ($marker->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $marker->delete();
        return redirect()->route('volunteer.marker.index');
    }
}
