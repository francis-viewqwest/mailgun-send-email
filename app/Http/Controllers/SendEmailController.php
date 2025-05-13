<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request)
    {

        app('App\Services\MailgunService')->sendEmail(
            $request->input('to'),
            $request->input('subject'),
            $request->input('text')
        );

        return response()->json(['message' => 'Email sent successfully']);
    }
}
