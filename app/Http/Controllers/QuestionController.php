<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * Store a new question
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|string',
            'type' => 'required|in:text,radio,checkbox,rating',
            'is_required' => 'boolean',
            'order' => 'nullable|integer'
        ]);

        $question = Question::create($data);

        return response()->json(['message' => 'Question added successfully', 'question' => $question], 201);
    }

    /**
     * Update an existing question
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $data = $request->validate([
            'text' => 'sometimes|string',
            'type' => 'sometimes|in:text,radio,checkbox,rating',
            'is_required' => 'sometimes|boolean',
            'order' => 'nullable|integer'
        ]);

        $question->update($data);

        return response()->json(['message' => 'Question updated successfully', 'question' => $question]);
    }

    /**
     * Delete a question
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json(['message' => 'Question deleted successfully']);
    }
}
