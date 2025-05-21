<?php

namespace App\Http\Controllers;
use App\Mail\EmailTask;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    //
public function sendTaskMail(Request $request) {
       
       $validated = $request->validate([
        'email' => 'required|email',
        'title' => 'required|string',
        'description' => 'required|string',
    ]);

    try {
        $data = [
            'email' => $validated['email'],
            'title' => $validated['title'],
            'description' => $validated['description'],
        ];

        Mail::to($validated['email'])->send(new EmailTask($data));

        return response()->json(['success' => true, 'message' => 'Email sent successfully.']);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send email.',
            'error' => $e->getMessage()
        ], 500);
    }

}
}
