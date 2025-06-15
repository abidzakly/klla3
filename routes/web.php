<?php

use App\Enums\PhotoEventTypeEnum;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\SPKController;
use App\Http\Controllers\PhotoEventController;
use App\Models\PhotoEventType;
use App\Models\Branch;
use App\Models\PhotoEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // get all photo event types
    $data['photoEventTypes'] = PhotoEventType::all();
    $data['photoEventTypeEnum'] = new PhotoEventTypeEnum();

    $photoEventTypes = PhotoEventType::all();
    $photoEvents = [];
    foreach ($photoEventTypes as $photoEventType) {
        $lastPhotoEvent = PhotoEvent::where('photo_event_type_id', $photoEventType->id_photo_event_type)
            ->orderBy('photo_event_date', 'desc')
            ->first();
        if ($lastPhotoEvent) {
            $lastPhotoEvent->photo_event_date = Carbon::parse($lastPhotoEvent->photo_event_date)->format('d-m-Y');
            $photoEvents[$photoEventType->id_photo_event_type] = $lastPhotoEvent;
        }
    }
    $data['photoEvents'] = $photoEvents;
    return view('dashboard', $data);
})->name('dashboard');

Route::get('/dashboard', function () {
    // get all photo event types
    $data['photoEventTypes'] = PhotoEventType::all();
    $data['photoEventTypeEnum'] = new PhotoEventTypeEnum();

    $photoEventTypes = PhotoEventType::all();
    $photoEvents = [];
    foreach ($photoEventTypes as $photoEventType) {
        $lastPhotoEvent = PhotoEvent::where('photo_event_type_id', $photoEventType->id_photo_event_type)
            ->orderBy('photo_event_date', 'desc')
            ->first();
        if ($lastPhotoEvent) {
            $lastPhotoEvent->photo_event_date = Carbon::parse($lastPhotoEvent->photo_event_date)->format('d-m-Y');
            $photoEvents[$photoEventType->id_photo_event_type] = $lastPhotoEvent;
        }
    }
    $data['photoEvents'] = $photoEvents;
    return view('dashboard', $data);
})->name('dashboard');

Route::get('/dataSPK', function (Request $request) {
    $branch = Branch::where('branch_name', $request->branch)->first() ?? Branch::all()->first();
    return view('SPK.index', compact('branch'));
})->name('data.spk');

Route::get('/dataUndangan', function (Request $request) {
    $branch = Branch::where('branch_name', $request->branch)->first() ?? Branch::all()->first();
    return view('invitation.index', compact('branch'));
})->name('data.undangan');

Route::resource('invitation', InvitationController::class);
Route::post('/invitation/save', [InvitationController::class, 'save'])->name('invitation.save');

Route::resource('spk', SPKController::class);
Route::post('/spk/save', [SPKController::class, 'save'])->name('spk.save');

Route::get('/foto/{photoEventType:photo_event_type_name}', [PhotoEventController::class, 'index'])->name('photo.event.type');
Route::resource('photo-event', PhotoEventController::class)->except(['create', 'edit', 'show']);
Route::post('/photo-event/{photoEventType}', [PhotoEventController::class, 'store'])->name('photo-event.store');
Route::get('/photo-event/data', [PhotoEventController::class, 'getData'])->name('photo-event.data');
Route::delete('/photo-event/{photoEvent}', [PhotoEventController::class, 'destroy'])->name('photo-event.destroy');
Route::post('/photo-event/{photoEvent}/rename', [PhotoEventController::class, 'rename'])->name('photo-event.rename');
Route::get('/photo-event/{photoEvent}', [PhotoEventController::class, 'show'])->name('photo-event.show');
