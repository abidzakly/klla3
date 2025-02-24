<?php
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DataController::class, 'index'])->name('dashboard');

Route::get('/inputSelect', function () {
    return view('inputSelect');
})->name('input.select');

Route::get('/inputDO', function () {
    return view('inputDO');
})->name('inputDO');

Route::get('/inputSPK', function () {
    return view('inputSPK');
})->name('inputSPK');

Route::resource('data', DataController::class);
