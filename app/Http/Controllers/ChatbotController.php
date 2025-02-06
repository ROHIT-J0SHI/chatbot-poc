<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatbotUser;
use Illuminate\Support\Facades\Mail;

class ChatbotController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'message' => 'nullable|string',
            ]);
    
            // Save chatbot user data to the database
            $chatbotUser = ChatbotUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
            ]);
    
            // Send email notification to admin
            Mail::raw("New Chatbot Submission:\n\nName: {$request->name}\nEmail: {$request->email}\nPhone: {$request->phone}\nMessage: {$request->message}", function ($message) {
                $message->to('rohitjoshi0131@gmail.com')
                        ->subject('New Chatbot Submission');
            });
    
            return response()->json(['message' => 'User data saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
