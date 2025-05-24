<?php

namespace App\Http\Controllers;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
     public function sendResetLink(Request $request)
    {
        $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $token = Str::random(60);

    PasswordReset::updateOrCreate(
        ['email' => $request->email],
        ['token' => $token, 'created_at' => Carbon::now()]
    );

   $resetLink = url("/reset-password?token=$token&email=" . urlencode($request->email));

    Mail::html('
        <p>You requested a password reset.</p>
        <p>
            <a href="' . $resetLink . '" style="
                background-color: #007bff;
                padding: 10px 20px;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
            ">
                Reset Password
            </a>
        </p>
        <p>If you did not request this, you can ignore this email.</p>
    ', function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Reset Password Link');
    });

    return response()->json(['message' => 'Password reset link sent.']);
    }



    

     public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $reset = PasswordReset::where('email', $request->email)
                              ->where('token', $request->token)
                              ->first();

        if (!$reset) {
            return response()->json(['message' => 'Invalid or expired token.'], 400);
        }

        User::where('email', $request->email)
            ->update(['password' => bcrypt($request->password)]);

        $reset->delete();

        return response()->json(['message' => 'Password reset successfully.']);
    }
}

