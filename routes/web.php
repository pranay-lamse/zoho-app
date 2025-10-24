<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ZohoController;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/zoho/auth', [ZohoController::class, 'redirectToZoho'])->name('login');
Route::get('/zoho/callback', [ZohoController::class, 'handleCallback']);

Route::get('/events', [EventController::class, 'listEvents']);
Route::post('/book', [EventController::class, 'bookTicket']);
Route::get('/pay/{bookingId}', [EventController::class, 'payTicket']);

Route::post('/webhook/zoho', [EventController::class, 'handleZohoWebhook']);
Route::post('/webhook/razorpay', [EventController::class, 'handleRazorpayWebhook']);
