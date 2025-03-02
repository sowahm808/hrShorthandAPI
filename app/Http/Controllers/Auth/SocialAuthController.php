<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback(Request $request)
{
    try {
        // Get Google user data
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Find or create employee
        $employee = Employee::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(uniqid()), // Generate random password
                'role' => 'user' // Default role if not set
            ]
        );

        // Generate API token
        $token = $employee->createToken('api_token')->plainTextToken;

        // Ensure role is included and encoded properly
        $role = urlencode($employee->role);

        // Debug: Check if role is being retrieved correctly
        \Log::info("User Role: " . $role); // Add this to check logs


        // Redirect to Angular Google Callback Page
        return redirect()->away("http://localhost:4200/auth/google/callback?token=$token&email=" . urlencode($employee->email) . "&role=" . $role);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to authenticate.'], 500);
    }
}

}
