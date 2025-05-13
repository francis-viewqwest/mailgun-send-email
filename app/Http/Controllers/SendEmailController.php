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
}
