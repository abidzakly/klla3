<?php
use App\Http\Controllers\MonitoringDoSpkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MonitoringDoSpkController::class, 'index'])->name('dashboard');

Route::get('/inputSelect', function () {
    return view('inputSelect');
})->name('input.select');

Route::get('/inputDO', function () {
    return view('inputDO');
})->name('inputDO');

Route::get('/inputSPK', function () {
    return view('inputSPK');
})->name('inputSPK');

Route::resource('monitoring_do_spk', MonitoringDoSpkController::class)->except(['show']);

Route::get('/monitoring_do_spk/export', [MonitoringDoSpkController::class, 'export'])->name('monitoring_do_spk.export');
