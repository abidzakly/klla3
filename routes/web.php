<?php

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
    return view('dataUndangan');
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