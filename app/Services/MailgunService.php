<?php

namespace App\Services;

use Mailgun\Mailgun;

class MailgunService
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

    public function sendEmail($to, $subject, $text)
    {
        $params = [
            'from' => $this->from,
            'to'      => $to,
            'subject' => $subject,
            'text' => $text,
        ];

        $this->mailgun->messages()->send($this->domain, $params);
    }
}
