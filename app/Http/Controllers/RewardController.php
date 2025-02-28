<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * Retrieve reward data for a specific employee.
     */
    public function show($employee_id)
    {
        $reward = Reward::where('employee_id', $employee_id)->first();

        if (!$reward) {
            return response()->json(['message' => 'No reward found for this employee'], 404);
        }

        return response()->json($reward);
    }

    /**
     * Update or create reward data for a specific employee.
     */
    public function update(Request $request, $employee_id)
    {
        $data = $request->validate([
            'points' => 'sometimes|integer',
            'badges' => 'sometimes|array',
        ]);

        $reward = Reward::updateOrCreate(
            ['employee_id' => $employee_id],
            $data
        );

        return response()->json($reward);
    }
}
