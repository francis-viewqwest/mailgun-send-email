<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request)
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

        $html = view('emails.example', [
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

    public function sendWebhook(Request $request)
    {
        $validated = $request->validate([
            'issueKey' => 'required|string',
            'summary' => 'required|string',
            'status' => 'required|string',
            'comment' => 'required|string',
            'reporter' => 'required|email'
        ]);

        $validated['from'] = env('MAILGUN_DOMAIN'); // sample domain on Mailgun
        $validated['subject'] = 'Update on Your Jira Ticket: ' . $validated['issueKey'];

        $html = view('emails.send_webhook', [
            'summary' => $validated['summary'],
            'comment' => $validated['comment'],
            'status' => $validated['status'],
        ])->render();

        // app('App\Services\MailgunService')->sendEmail(
        //     $validated['from'],
        //     $validated['reporter'],
        //     $validated['subject'],
        //     $html
        // );

        // $request->input('issueKey');

        return response()->json([
            'message' => 'Email sent successfully', 
            'jira' => $validated,
            'html' => $html
        ]);
    }
}
