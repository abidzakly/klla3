<?php

use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/jenisEvent', function () {
    return view('jenisEvent');
})->name('jenis.event');


Route::get('/dataUndangan', function () {
    return view('invitation.index');
})->name('data.undangan');


Route::get('/dataSPK', function () {
    return view('dataSPK');
})->name('data.spk');


Route::get('/evaluasi', function () {
    return view('evaluasi');
})->name('evaluasi');

Route::get('/kwitansi', function () {
    return view('kwitansi');
})->name('kwitansi');

Route::get('/detailBiaya', function () {
    return view('detailBiaya');
})->name('detail.biaya');

Route::resource('invitation', InvitationController::class);

Route::post('/invitation/save', [InvitationController::class, 'save'])->name('invitation.save');
