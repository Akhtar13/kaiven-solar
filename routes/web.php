<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('genrate-quotation');
});
Route::get('/genrate-quotation', [HomeController::class, 'genrateQuotation'])->name('genrate-quotation');
Route::post('/store-quotation', [HomeController::class, 'storeQuotation'])->name('store-quotation');
Route::get('/thank-you-page', [HomeController::class, 'generateQuotationPDF'])->name('thank-you');
Route::post('/send-otp', [HomeController::class, 'sendOtp'])->name('send-otp');
