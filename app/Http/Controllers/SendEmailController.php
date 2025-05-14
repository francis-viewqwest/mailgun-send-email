<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mailgun\Mailgun;

class SendEmailController extends Controller
{

    protected $mailgun;
    protected $domain;
    protected $from;

    public function __construct()
    {
        $this->mailgun = Mailgun::create(env('MAILGUN_SECRET'));
        $this->domain = env('MAILGUN_DOMAIN');
        $this->from = config('mail.from.address');
    }


    public function sendEmail(Request $request)
    {

        $response = app('App\Services\MailgunService')->sendEmail($request->all());

        return response()->json([
            'message' => 'Email sent successfully',
            'response' => $response,
            'mailgun_response' => $response->getMessage(),
            'mailgun_id' => $response->getId()
        ]);
    }

    public function webhhookReceiver(Request $request)
    {

        $inputs = $request->all();

        $html = view('emails.send_webhook', [
            'message_id' => $inputs['h:Message-Id'] ?? false,
            'summary' => $inputs['summary'] ?? false,
            'status' => $inputs['status'] ?? false,
            'comment' => $inputs['comment'] ?? false,
            'in_reply_to' => $inputs['h:In-Reply-To'] ?? false
        ])->render();

        $params = [
            'to' => $inputs['to'] ?? $inputs['reporter'],
            'subject' => array_key_exists('h:In-Reply-To', $inputs) ? 'RE: (' . $inputs['issueKey'] . ') Ticket Update' : 'Update on Your Jira Ticket: ' . $inputs['issueKey'],
            'html' => $html
        ];

        $mergedPayload = array_merge($inputs, $params);

        $response = app('App\Services\MailgunService')->sendEmail($mergedPayload);

        return response()->json([
            'message' => 'Email sent successfully',
            'response' => $response,
            'mailgun_response' => $response->getMessage(),
            'mailgun_id' => $response->getId()
        ]);
    }
}
