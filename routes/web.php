<?php

use App\Enums\PhotoEventTypeEnum;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\SPKController;
use App\Http\Controllers\PhotoEventController;
use App\Models\PhotoEventType;
use App\Models\Branch;
use App\Models\PhotoEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // get all photo event types
    $data['photoEventTypes'] = PhotoEventType::all();
    $data['photoEventTypeEnum'] = new PhotoEventTypeEnum();
    return view('dashboard', $data);
})->name('dashboard');

Route::get('/dashboard', function () {
    // get all photo event types
    $data['photoEventTypes'] = PhotoEventType::all();
    $data['photoEventTypeEnum'] = new PhotoEventTypeEnum();
    return view('dashboard', $data);
})->name('dashboard');

Route::get('/dataSPK', function () {
    return view('SPK.index');
})->name('data.spk');

Route::get('/dataUndangan', function () {
    return view('invitation.index');
})->name('data.undangan');

Route::get('/foto/{photoEventType:photo_event_type_name}', function (Request $request, PhotoEventType $photoEventType) {
    $branch = Branch::where('branch_name', $request->branch)->first() ?? App\Models\Branch::all()->first();
    $photoEvents = PhotoEvent::where('photo_event_type_id', $photoEventType->id_photo_event_type)->where('branch_id', $branch->id_branch)->get();
    return view('photo_event.index', ['photoEventType' => $photoEventType, 'branch' => $branch, 'photoEvents' => $photoEvents]);
})->name('photo.event.type');

Route::resource('invitation', InvitationController::class);
Route::post('/invitation/save', [InvitationController::class, 'save'])->name('invitation.save');

Route::resource('spk', SPKController::class);
Route::post('/spk/save', [SPKController::class, 'save'])->name('spk.save');

Route::resource('photo-event', PhotoEventController::class)->except(['create', 'edit', 'show']);
Route::post('/photo-event/{photoEventType}', [PhotoEventController::class, 'store'])->name('photo-event.store');
Route::get('/photo-event/data', [PhotoEventController::class, 'getData'])->name('photo.event.data');
Route::delete('/photo-event/{photoEvent}', [PhotoEventController::class, 'destroy'])->name('photo-event.destroy');
Route::post('/photo-event/{photoEvent}/rename', [PhotoEventController::class, 'rename'])->name('photo-event.rename');
