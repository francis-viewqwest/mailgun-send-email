<?php

use App\Services\MailgunService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test', function () {
    return response()->json([
        'message' => 'hello world'
    ]);
});

Route::get('/send-template', function (MailgunService $mailgun) {
    $html = View::make('emails.example', [
        'title' => 'email',
        'messageBody' => 'Test email body',
    ])->render();

    $mailgun->sendEmail('recipient@example.com', 'Welcome Email', 'fix this issue', $html);

    return 'Styled email sent using Mailgun API';
});