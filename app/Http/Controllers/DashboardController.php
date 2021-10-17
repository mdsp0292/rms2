<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard/DashboardIndex', [
            'stats' => (new DashboardService)->getStats()
        ]);
    }
}
