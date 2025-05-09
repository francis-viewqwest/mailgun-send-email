<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function  (Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|email',
            'to' => 'required|email',
            'cc' => 'array',
            'cc.*' => 'email',
            'bcc' => 'array',
            'bcc.*' => 'email',
            'subject' => 'required|string',
            'comments' => 'required|string',
        ]);

        $html = view('emails.mail_send', [
            'title' => $validated['subject'],
            'messageBody' => $validated['comments'],
        ])->render();


        app('App\Services\MailgunService')->sendEmail(
            $validated['from'],
            $validated['to'],
            $validated['subject'],
            $html,
            $validated['cc'] ?? [],
            $validated['bcc'] ?? []
        );

        return response()->json(['message' => 'Email sent successfully']);
    }

}