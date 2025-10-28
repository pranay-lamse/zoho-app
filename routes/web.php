<?php

use App\Http\Controllers\CsvImportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ZohoController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});


Route::post('/zoho/logout', [ZohoController::class, 'logout'])->name('zoho.logout');
Route::get('/zoho/auth', [ZohoController::class, 'redirectToZoho'])->name('login');
Route::get('/zoho/callback', [ZohoController::class, 'handleCallback']);

Route::get('/events', [EventController::class, 'listEvents']);
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/book', [EventController::class, 'bookTicket']);
Route::get('/pay/{bookingId}', [EventController::class, 'payTicket']);

Route::post('/webhook/zoho', [EventController::class, 'handleZohoWebhook']);
Route::post('/webhook/razorpay', [EventController::class, 'handleRazorpayWebhook']);


Route::get('/csv-upload', function () {
    return view('csv-upload');
})->name('csv.upload');

Route::post('/import-csv', [CsvImportController::class, 'import'])->name('import.csv');

Route::get('/sample-csv', function () {
    $filePath = public_path('sample_import.csv');
    return response()->download($filePath, 'sample.csv');
})->name('sample.csv');
