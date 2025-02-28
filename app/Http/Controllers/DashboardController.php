<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Return analytics data for the management dashboard.
     */
    public function index()
    {
        // Total number of surveys submitted
        $totalSurveys = Survey::count();

        // Example: additional metrics (customize as needed)
        $data = [
            'total_surveys' => $totalSurveys,
            // 'average_score' => ...,
            // 'trends' => ...,
        ];

        return response()->json($data);
    }
}
