<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request)
    {

        app('App\Services\MailgunService')->sendEmail($request->all());

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function webhhookReceiver(Request $request)
    {
        $html = view('emails.send_webhook', [
            'summary' => $request['summary'],
            'comment' => $request['comment'],
            'status' => $request['status'],
            'message_id' => $request->input('h:Message-Id') ?? false
        ])->render();

        $params = [
            'to' => $request['to'] ?? $request['reporter'],
            'subject' => $request->input('h:Message-Id') ? 'RE: ' . $request['issueKey'] . ' Ticket Update' : 'Update on Your Jira Ticket: ' . $request['issueKey'],
            'html' => $html
        ];
        
        $mergedPayload = array_merge($request->all(), $params);

        app('App\Services\MailgunService')->sendEmail($mergedPayload);
    }
}
