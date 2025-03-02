<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // <-- Added this line
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

    // Attempt to authenticate
    if (Auth::attempt($credentials)) {
        $employee = Auth::user();

        // Generate Sanctum token
        $token = $employee->createToken('api_token')->plainTextToken;

        return response()->json([
            //'employee' => $employee,
            'employee' => [
                'id'    => $employee->id,
                'name'  => $employee->name,
                'email' => $employee->email,
                'role'  => $employee->role, // Include role in response
            ],
            'token' => $token,
            'redirect_to' => $employee->isAdmin() ? '/admin-dashboard' : '/dashboard'

        ]);
    }
    if (Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }
    
    return response()->json(['message' => 'Invalid credentials'], 401);
}


    /**
     * Revoke the current API token for logout.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Register a new employee and issue a token.
     */
    // Register and issue token
public function register(Request $request)
{
    // Validate registration data
    $validatedData = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:employees,email',
        'password' => 'required|string|min:6|confirmed'
    ]);

    // Check if email exists but not confirmed
    $existingEmployee = Employee::where('email', $validatedData['email'])->first();
    if ($existingEmployee) {
        return response()->json([
            'message' => 'This email is already registered. Please use a different email or log in.',
            'errors' => ['email' => ['This email is already registered.']]
        ], 409); // 409 Conflict
    }

    // Create new employee
    $employee = Employee::create([
        'name'     => $validatedData['name'],
        'email'    => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'role'     => 'user' // Default role assigned
    ]);

    // Auto-login after registration
    $token = $employee->createToken('api_token')->plainTextToken;

    return response()->json([
        //'employee' => $employee,
        'employee' => [
            'id'    => $employee->id,
            'name'  => $employee->name,
            'email' => $employee->email,
            'role'  => $employee->role, // Include role
        ],
        'token'    => $token
    ], 201);
}
}
