<?php

use App\Http\Controllers\SendEmailController;
use App\Services\MailgunService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/test', function () {
    return response()->json([
        'message' => 'hello world'
    ]);
});

Route::post('/send-email', [SendEmailController::class, 'sendEmail']);

Route::post('/webhook-receiver', [SendEmailController::class, 'webhhookReceiver']);
