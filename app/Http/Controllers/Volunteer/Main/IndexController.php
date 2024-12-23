<?php

namespace App\Http\Controllers\Volunteer\Main;

use App\Http\Controllers\Controller;
use App\Services\Volunteer\VolunteerDashboardService;

class IndexController extends Controller
{
    protected $dashboardService;

    public function __construct(VolunteerDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function __invoke()
    {
        $data = $this->dashboardService->getDashboardData();
        return view('volunteer.main.index', compact('data'));
    }
}
