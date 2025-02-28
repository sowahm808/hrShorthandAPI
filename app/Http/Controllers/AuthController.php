<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class AuthController extends Controller
{
    /**
     * Authenticate an employee and return an API token.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $employee = Auth::user();

        // Generate an API token (requires Laravel Sanctum or Passport)
        $token = $employee->createToken('api_token')->plainTextToken;

        return response()->json([
            'employee' => $employee,
            'token'    => $token,
        ]);
    }

    /**
     * Revoke the current API token for logout.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
