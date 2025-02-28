<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Response;
use App\Notifications\NegativeResponseAlert;
use Illuminate\Support\Facades\Notification;

class SurveyController extends Controller
{
    public function index()
    {
        // Return static questions for simplicity.
        $questions = [
            "How aware are you of the company vision?",
            "Do you view your skills as an asset to the company?",
            "How clear are your job expectations?",
            "How would you rate coworker support and collaboration?",
            "Are necessary resources available for your tasks?",
            "Overall job satisfaction and would you recommend this job?",
            "Do you see long-term commitment here? Suggestions for improvement?"
        ];
        return response()->json($questions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|integer',
            'responses'   => 'required|array',
            'survey_date' => 'required|date'
        ]);

        // Save survey record.
        $survey = Survey::create([
            'employee_id' => $data['employee_id'],
            'survey_date' => $data['survey_date']
        ]);

        // Save each response.
        foreach ($data['responses'] as $questionId => $answer) {
            Response::create([
                'survey_id'   => $survey->id,
                'question_id' => $questionId,
                'answer'      => $answer,
            ]);
        }

        // Trigger alerts if responses are below a threshold.
        if ($this->shouldAlert($data['responses'])) {
            Notification::route('mail', 'manager@company.com')
                ->notify(new NegativeResponseAlert($survey));
        }

        return response()->json(['message' => 'Survey submitted successfully'], 201);
    }

    protected function shouldAlert(array $responses)
    {
        // Example: Trigger alert if any answer is below 3 (on a 1-5 scale)
        foreach ($responses as $answer) {
            if ($answer < 3) {
                return true;
            }
        }
        return false;
    }

    public function dashboard()
    {
        // Build and return analytics data for the dashboard.
        $data = []; // Replace with actual queries and trend analysis logic.
        return response()->json($data);
    }
}
