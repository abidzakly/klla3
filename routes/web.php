<?php

use App\Http\Controllers\MonitoringDoSpkController;
use App\Models\MonitoringDoSpk;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [MonitoringDoSpkController::class, 'index'])->name('dashboard');

Route::get('/inputSelect', function () {
    return view('inputSelect');
})->name('input.select');

Route::get('/inputDO', function (Request $request) {
    $date = Carbon::parse($request->input('date', now()->format('Y-m-d')));

    $supervisors = Supervisor::where('status', 1)->get();
    $data = MonitoringDoSpk::select(
        'supervisors.supervisor_name',
        'monitoring_do_spk.id_monitoring_do_spk',
        'monitoring_do_spk.target_do',
        'monitoring_do_spk.act_do',
        'monitoring_do_spk.mpp',
        'monitoring_do_spk.productivity',
        'monitoring_do_spk.gap_do',
        'monitoring_do_spk.ach_do',
        'monitoring_do_spk.id_supervisor'
    )
        ->join('supervisors', 'monitoring_do_spk.id_supervisor', '=', 'supervisors.id_supervisor')
        ->where('monitoring_do_spk.date', $date)
        ->orderBy('supervisors.created_at', 'asc') // atau 'desc'
        ->get()
        ->keyBy('id_supervisor');

    $dataSupervisor = [];

    foreach ($supervisors as $supervisor) {
        $obj = new \stdClass();
        $obj->id_monitoring_do_spk = null;
        $obj->id_supervisor = $supervisor->id_supervisor;
        $obj->supervisor_name = $supervisor->supervisor_name;
        $obj->target_do = '';
        $obj->act_do = '';
        $obj->gap_do = '';
        $obj->ach_do = '';
        $obj->mpp = '';
        $obj->productivity = '';

        $dataSupervisor[$supervisor->id_supervisor] = $obj;
    }

    foreach ($data as $idSupervisor => $values) {
        if (isset($dataSupervisor[$idSupervisor])) {

            $dataSupervisor[$idSupervisor]->id_monitoring_do_spk = $values->id_monitoring_do_spk;
            $dataSupervisor[$idSupervisor]->target_do = $values->target_do;
            $dataSupervisor[$idSupervisor]->act_do = $values->act_do;
            $dataSupervisor[$idSupervisor]->gap_do = round($values->gap_do) . "%";
            $dataSupervisor[$idSupervisor]->ach_do = round($values->ach_do) . "%";
            $dataSupervisor[$idSupervisor]->mpp = round($values->mpp);
            $dataSupervisor[$idSupervisor]->productivity = round($values->productivity) . "%";
        }
    }

    if ($request->ajax()) {
        return response()->json(['dataSupervisors' => array_values($dataSupervisor)]);
    }

    $data['dataSupervisors'] = $dataSupervisor;
    return view('inputDO', $data);
})->name('inputDO');

Route::get('/inputSPK', function (Request $request) {
    $date = Carbon::parse($request->input('date', now()->format('Y-m-d')));

    $supervisors = Supervisor::where('status', 1)->get();
    $data = MonitoringDoSpk::select(
        'monitoring_do_spk.id_monitoring_do_spk',
        'supervisors.supervisor_name',
        'monitoring_do_spk.target_spk',
        'monitoring_do_spk.act_spk',
        'monitoring_do_spk.gap_spk',
        'monitoring_do_spk.ach_spk',
        'monitoring_do_spk.id_supervisor'
    )
        ->join('supervisors', 'monitoring_do_spk.id_supervisor', '=', 'supervisors.id_supervisor')
        ->where('monitoring_do_spk.date', $date)
        ->orderBy('supervisors.created_at', 'asc')
        ->get()
        ->keyBy('id_supervisor');

    $dataSupervisor = [];
    foreach ($supervisors as $supervisor) {
        $obj = new \stdClass();
        $obj->id_monitoring_do_spk = null;
        $obj->id_supervisor = $supervisor->id_supervisor;
        $obj->supervisor_name = $supervisor->supervisor_name;
        $obj->target_spk = '';
        $obj->act_spk = '';
        $obj->gap_spk = '';
        $obj->ach_spk = '';
        $dataSupervisor[$supervisor->id_supervisor] = $obj;
    }
    foreach ($data as $idSupervisor => $values) {
        if (isset($dataSupervisor[$idSupervisor])) {
            $dataSupervisor[$idSupervisor]->id_monitoring_do_spk = $values->id_monitoring_do_spk;
            $dataSupervisor[$idSupervisor]->target_spk = $values->target_spk;
            $dataSupervisor[$idSupervisor]->act_spk = $values->act_spk;
            $dataSupervisor[$idSupervisor]->gap_spk = round($values->gap_spk) . "%";
            $dataSupervisor[$idSupervisor]->ach_spk = round($values->ach_spk) . "%";
        }
    }

    if ($request->ajax()) {
        return response()->json(['dataSupervisors' => array_values($dataSupervisor)]);
    }

    $data['dataSupervisors'] = $dataSupervisor;
    return view('inputSPK', $data);
})->name('inputSPK');

Route::resource('monitoring_do_spk', MonitoringDoSpkController::class)->except(['show']);

Route::get('/monitoring_do_spk/export', [MonitoringDoSpkController::class, 'export'])->name('monitoring_do_spk.export');

Route::get('/supervisors/list', function () {
    $data = \App\Models\Supervisor::where('status', 1)
        ->select('id_supervisor', 'supervisor_name')
        ->orderBy('supervisor_name')
        ->get();
    return response()->json(['data' => $data]);
});
