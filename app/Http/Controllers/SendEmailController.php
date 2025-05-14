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

    public function sendEmailCustomFields(Request $request)
    {

        $inputs = $request->all();

        $mailgunPayload = [
            // 'h:Message-ID' => $inputs['new_message_id'],
            'h:In-Reply-To' => $inputs['original_message_id'],
            'h:References' => $inputs['thread_reference']
        ];

        //* Send the email
        $response = app('App\Services\MailgunService')->sendEmail($inputs);

        $jiraIssueKey = $inputs['issueKey'];
        $newId = method_exists($response, 'getId') ? $response->getId() : null;

        $jiraPayload = [
            'fields' => [
                'customfield_10059' => $newId,
                'customfield_10049' => $inputs['original_message_id'],
                'customfield_10050' => $inputs['thread_reference'],
            ]
        ];

        //* Send to Jira
        $jiraResponse = Http::withBasicAuth(env('JIRA_EMAIL'), env('JIRA_API_TOKEN'))
            ->put(env('JIRA_BASE_URL') . "/rest/api/3/issue/{$jiraIssueKey}", $jiraPayload);

        return response()->json([
            'mailgun_id' => method_exists($response, 'getId') ? $response->getId() : null,
            'jira' => $jiraResponse->json()
        ]);
    }
}
