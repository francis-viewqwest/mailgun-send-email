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

    public function sendEmail($from, $to, $subject, $html, $cc = [], $bcc = [], $attachments = [], $text = null)
    {
        $params = [
            'from'    => $from,
            'to'      => $to,
            'subject' => $subject,
            'html'    => $html,
        ];

        if ($text) $params['text'] = $text;
        if (!empty($cc)) $params['cc'] = $cc;
        if (!empty($bcc)) $params['bcc'] = $bcc;
        if (!empty($attachments)) {
            $params['attachment'] = $attachments;
        }

        $this->mailgun->messages()->send($this->domain, $params);
    }
}
