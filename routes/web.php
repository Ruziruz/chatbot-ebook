<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use App\Models\ReferralCode;

Route::get('/', function () {
    return view('welcome');
})->middleware('referral');

Route::post('/chat', [ChatController::class, 'chat'])->middleware('referral');

Route::get('/referral', function () {
    return view('referral'); // Buat halaman referral.blade.php
})->name('referral');

Route::post('/referral', function (Request $request) {
    $code = $request->input('code');

    if (ReferralCode::where('code', $code)->exists()) {
        session(['referral_code' => $code]);
        return redirect('/');
    }

    return back()->withErrors(['code' => 'Kode referral tidak valid!']);
});
