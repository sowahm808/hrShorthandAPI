<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // ✅ Added Schema import

class DashboardController extends Controller
{
    /**
     * Return analytics data for the management dashboard.
     */
    public function index()
    {
        try {
            // 🔹 1️⃣ Total number of surveys submitted
            $totalSurveys = Survey::count();

            // 🔹 2️⃣ Calculate Average Score for Numeric Questions
            $averageScore = Response::whereRaw('answer REGEXP "^[0-9]+$"')
                ->select(DB::raw('AVG(CAST(answer AS UNSIGNED)) as avg_score'))
                ->first();
            $averageScore = $averageScore ? round($averageScore->avg_score, 2) : 0; // ✅ Prevents NULL errors

            // 🔹 3️⃣ Survey Submission Trends (Daily Count for the Last 7 Days)
            $surveyTrends = Survey::whereNotNull('survey_date')
                ->select(DB::raw('DATE(survey_date) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw('DATE(survey_date)')) // ✅ Fix for strict mode issues
                ->orderBy('date', 'desc')
                ->limit(7) // Last 7 days
                ->get();

            // 🔹 4️⃣ Most Common Responses
            $commonResponses = Response::select('answer', DB::raw('count(*) as count'))
                ->whereNotNull('answer')
                ->groupBy('answer')
                ->orderByDesc('count')
                ->limit(5) // Top 5 most common responses
                ->get();

            // 🔹 5️⃣ Department-wise Survey Participation
            $departmentParticipation = [];
            if (Schema::hasColumn('employees', 'department')) {
                $departmentParticipation = DB::table('surveys')
                    ->join('employees', 'surveys.employee_id', '=', 'employees.id')
                    ->select('employees.department', DB::raw('COUNT(surveys.id) as survey_count'))
                    ->groupBy('employees.department')
                    ->orderByDesc('survey_count')
                    ->get();
            }

            // Prepare JSON response
            $data = [
                'total_surveys' => $totalSurveys,
                'average_score' => $averageScore,
                'survey_trends' => $surveyTrends,
                'common_responses' => $commonResponses,
                'department_participation' => $departmentParticipation
            ];

            return response()->json($data, 200);

        } catch (\Exception $e) {
            \Log::error('Dashboard API Error:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}