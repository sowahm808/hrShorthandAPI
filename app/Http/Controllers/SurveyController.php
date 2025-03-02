<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Response;
use App\Models\Employee;
use App\Models\Question;

use App\Notifications\NegativeResponseAlert;
use Illuminate\Support\Facades\Notification;

class SurveyController extends Controller
{
    public function index()
    {
        $questions = Question::select('id', 'text', 'type', 'is_required', 'order')->get();

        return response()->json($questions);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'survey_date' => 'required|date_format:Y-m-d',
        'responses' => 'required|array',
        'responses.*.question_id' => 'required|exists:questions,id',
        'responses.*.answer' => 'required|string'
    ]);

    \Log::info('Survey Payload:', $request->json()->all()); // ✅ Debugging

    // Fetch the employee to confirm existence
    $employee = Employee::find($data['employee_id']);
    if (!$employee) {
        return response()->json(['message' => 'Employee not found'], 404);
    }

    // Create survey record
    $survey = Survey::create([
        'employee_id' => $employee->id,
        'survey_date' => $data['survey_date']
    ]);

    // Save each response correctly
    foreach ($data['responses'] as $response) {
        if (!empty($response['answer'])) { // ✅ Ignore empty responses
            Response::create([
                'survey_id'   => $survey->id,
                'question_id' => $response['question_id'], // ✅ Correct access
                'answer'      => $response['answer'],
            ]);
        }
    }

    // Trigger alerts if responses are below a threshold
    if ($this->shouldAlert($data['responses'])) {
        Notification::route('mail', 'manager@company.com')
            ->notify(new NegativeResponseAlert($survey));
    }

    return response()->json(['message' => 'Survey submitted successfully'], 201);
}

protected function shouldAlert(array $responses)
{
    foreach ($responses as $response) {
        if (isset($response['answer']) && is_numeric($response['answer']) && $response['answer'] < 3) {
            return true; // ✅ Trigger alert if a numeric answer is below 3
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
