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

    public function sendEmail(array $inputs)
    {

        $payloads = [];

        foreach ($inputs as $key => $value) {
            $payloads[$key] = $value;
        }

        $staticKeys = [
            'from' => $this->from,
        ];

        $mergedPayload = array_merge($payloads, $staticKeys);

        $this->mailgun->messages()->send($this->domain, $mergedPayload);
    }
}
