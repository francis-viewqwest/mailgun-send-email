<?php

namespace App\Services;

use Mailgun\Mailgun;

class MailgunService
{
    protected $mailgun;
    protected $domain;

    public function __construct()
    {
        $this->mailgun = Mailgun::create(env('MAILGUN_SECRET'));
        $this->domain = env('MAILGUN_DOMAIN');
    }

    public function sendEmail($to, $subject, $comment, $htmlContent)
    {
        $this->mailgun->messages()->send($this->domain, [
            'from'    => env('MAIL_FROM_ADDRESS', ''),
            'to'      => $to,
            'subject' => $subject,
            'comment' => $comment,
            'html'    => $htmlContent, 
        ]);
    }
}
