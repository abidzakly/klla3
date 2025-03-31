<?php

namespace App\Http\Controllers;

use App\Enums\MonitoringType;
use App\Enums\StatusMonitoringDoSpk;
use App\Models\MonitoringDoSpk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MonitoringDoSpkController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MonitoringDoSpk::query();

            $listSearch = [
                'nama_supervisor' => ['nama_supervisor'],
                'target_do' => ['target_do'],
                'act_do' => ['act_do'],
                'gap_do' => ['gap_do'],
                'ach_do' => ['ach_do'],
                'status' => ['status'],
                'target_spk' => ['target_spk'],
                'act_spk' => ['act_spk'],
                'gap_spk' => ['gap_spk'],
                'ach_spk' => ['ach_spk'],
                'created_at' => ['created_at'],
                'updated_at' => ['updated_at'],
            ];

            $data = self::filterDatatable($data, $listSearch);

            return DataTables::of($data)
                ->addColumn('nama_supervisor', function ($row) {
                    return '<div class="editable" data-name="nama_supervisor">' . $row->nama_supervisor . '</div>';
                })
                ->addColumn('target_do', function ($row) {
                    return '<div class="editable" data-name="target_do">' . $row->target_do . '</div>';
                })
                ->addColumn('act_do', function ($row) {
                    return '<div class="editable" data-name="act_do">' . $row->act_do . '</div>';
                })
                ->addColumn('gap_do', function ($row) {
                    return '<div class="editable" data-name="gap_do">' . $row->gap_do . '</div>';
                })
                ->addColumn('ach_do', function ($row) {
                    $format = $row->ach_do ? $row->ach_do . '%' : 0;
                    return '<div class="editable" data-name="ach_do">' . $format . '</div>';
                })
                ->addColumn('target_spk', function ($row) {
                    return '<div class="editable" data-name="target_spk">' . $row->target_spk . '</div>';
                })
                ->addColumn('act_spk', function ($row) {
                    return '<div class="editable" data-name="act_spk">' . $row->act_spk . '</div>';
                })
                ->addColumn('gap_spk', function ($row) {
                    return '<div class="editable" data-name="gap_spk">' . $row->gap_spk . '</div>';
                })
                ->addColumn('ach_spk', function ($row) {
                    $format = $row->ach_spk ? $row->ach_spk . '%' : 0;
                    return '<div class="editable" data-name="ach_spk">' . $format . '</div>';
                })
                ->addColumn('status', function ($row) {
                    $statusColors = [
                        StatusMonitoringDoSpk::ON_THE_TRACK => 'bg-green-500',
                        StatusMonitoringDoSpk::PUSH_SPK => 'bg-red-500',
                    ];

                    $colorClass = $statusColors[$row->status] ?? 'bg-gray-500';

                    return '<p class="mx-auto px-3 py-1 text-white rounded-lg status_text text-nowrap text-center ' . $colorClass . '" style="min-width: 140px;width: 140px">
                        ' . ucfirst($row->status) . '
                    </p>';
                })
                ->addColumn('action', function ($row) {
                    $editButton = '<button class="flex items-center gap-2 px-4 py-2 text-white transition duration-300 bg-green-500 rounded-lg hover:bg-green-600 edit" 
                        data-id="' . $row->id_monitoring_do_spk . '">
                        Edit <i class="ti ti-edit"></i>
                    </button>';

                    $deleteButton = '<button class="flex items-center gap-2 px-4 py-2 text-white transition duration-300 bg-red-500 rounded-lg hover:bg-red-600 delete" 
                        data-id="' . $row->id_monitoring_do_spk . '">
                        Delete <i class="ti ti-trash"></i>
                    </button>';

                    return '<div class="flex justify-center items-center gap-2 action-buttons">' . $editButton . ' ' . $deleteButton . '</div>';
                })
                ->rawColumns(['nama_supervisor', 'target_do', 'act_do', 'gap_do', 'ach_do', 'target_spk', 'act_spk', 'gap_spk', 'ach_spk', 'status', 'action'])
                ->order(function ($query) {
                    if (request()->has('order')) {
                        $order = request('order')[0];
                        $columns = request('columns');
                        $query->orderBy($columns[$order['column']]['data'], $order['dir']);
                    }
                })
                ->make(true);
        }

        $lastTypeInput = MonitoringDoSpk::orderBy('created_at', 'desc')
        ->orWhere('act_do', null)
        ->orWhere('target_do', null)
        ->orWhere('act_spk', null)
        ->orWhere('target_spk', null)
        ->first();
        $data['lastType'] = $lastTypeInput?->act_do && $lastTypeInput?->target_do ? 'SPK' : 'DO';
        return view('dashboard', $data);
    }

    private static function filterDatatable($query, $searchColumns)
    {
        $searchValue = request('search.value');
        if ($searchValue) {
            $query->where(function ($query) use ($searchColumns, $searchValue) {
                foreach ($searchColumns as $column => $fields) {
                    foreach ($fields as $field) {
                        $query->orWhere($field, 'like', '%' . $searchValue . '%');
                    }
                }
            });
        }
        return $query;
    }

    public function store(Request $request)
    {
        if (count($request->data) == 1) {
            $rules = [
                'data.0.nama_supervisor' => 'required|string',
                'type' => 'required|in:all,' . implode(',', MonitoringType::values()),
            ];

            $type = $request->type;
            if ($type === 'all') {
                $rules = array_merge($rules, [
                    'target_do' => 'required|integer',
                    'act_do' => 'required|integer',
                    'target_spk' => 'required|integer',
                    'act_spk' => 'required|integer',
                ]);
            } elseif ($type === MonitoringType::DO) {
                $rules = array_merge($rules, [
                    'data.0.target_do' => 'required|integer',
                    'data.0.act_do' => 'required|integer',
                ]);
            } elseif ($type === MonitoringType::SPK) {
                $rules = array_merge($rules, [
                    'data.0.target_spk' => 'required|integer',
                    'data.0.act_spk' => 'required|integer',
                ]);
            }

            $validator = Validator::make($request->all(), $rules);

            $validator->after(function ($validator) use ($rules) {
                $validator->addRules($rules);
            });

            if ($validator->fails()) {
                // return response()->json(['errors' => $validator->errors()], 422);
                return response()->json(['message' => 'Data ' . $request->type . ' gagal disimpan. Pastikan semua data terisi.'], 422);
            }
        }

        DB::beginTransaction();

        try {
            foreach ($request->data as $key => $row) {

                if ($key == 0 && count($request->data) > 1) {
                    $isFilled = array_filter($row);

                    if ($isFilled && in_array(null, $row)) {
                        return response()->json(['message' => 'Data ' . $request->type . ' gagal disimpan. Pastikan semua data terisi.'], 422);
                    }

                    continue;
                } else {
                    if (in_array(null, $row)) {
                        return response()->json(['message' => 'Data ' . $request->type . ' gagal disimpan. Pastikan semua data terisi.'], 422);
                    }
                }

                $namaSupervisor = strtolower($row['nama_supervisor']);
                $isAll = $request->type == 'all';
                $existingData = null;

                if (!$isAll) {
                    $existingData = MonitoringDoSpk::whereRaw('LOWER(nama_supervisor) = ?', [$namaSupervisor])
                        ->orderBy('created_at', 'asc');
                }

                if ($request->type === MonitoringType::DO) {
                    $existingData->where('act_do', null)->where('target_do', null);
                    $newData = new MonitoringDoSpk([
                        'nama_supervisor' => $row['nama_supervisor'],
                        'target_do' => $row['target_do'],
                        'act_do' => $row['act_do']
                    ]);
                } elseif ($request->type === MonitoringType::SPK) {
                    $existingData->where('act_spk', null)->where('target_spk', null);
                    $newData = new MonitoringDoSpk([
                        'nama_supervisor' => $row['nama_supervisor'],
                        'target_spk' => $row['target_spk'],
                        'act_spk' => $row['act_spk']
                    ]);
                } else {
                    $newData = new MonitoringDoSpk([
                        'nama_supervisor' => $row['nama_supervisor'],
                        'target_do' => $row['target_do'],
                        'act_do' => $row['act_do'],
                        'target_spk' => $row['target_spk'],
                        'act_spk' => $row['act_spk']
                    ]);
                }

                if ($existingData) {
                    $existingData = $existingData->first();
                }

                $this->calculateStatus($newData, $request->type);

                if ($existingData && !$isAll) {
                    if ($request->type === MonitoringType::DO) {
                        if ($existingData->ach_do) {
                            $newData->save();
                        } else {
                            $existingData->update($newData->only(['target_do', 'act_do', 'gap_do', 'ach_do']));
                            $newData = $existingData;
                        }
                    } elseif ($request->type === MonitoringType::SPK) {
                        if ($existingData->ach_spk) {
                            $newData->save();
                        } else {
                            $existingData->update($newData->only(['target_spk', 'act_spk', 'gap_spk', 'ach_spk']));
                            $newData = $existingData;
                        }
                    }
                } else {
                    $newData->save();
                }
            }

            DB::commit();
            return response()->json(['message' => 'Data ' . $request->type . ' berhasil disimpan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = MonitoringDoSpk::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nama_supervisor' => 'nullable|string',
                'target_do' => 'nullable|integer',
                'act_do' => 'nullable|integer',
                'target_spk' => 'nullable|integer',
                'act_spk' => 'nullable|integer',
                'status' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $dataUodate = new MonitoringDoSpk($request->only(['nama_supervisor', 'target_do', 'act_do', 'target_spk', 'act_spk']));
            $dataUpdate = $this->calculateStatus($dataUodate, 'all');
            $data->update($dataUpdate->only(['nama_supervisor', 'target_do', 'act_do', 'target_spk', 'act_spk', 'gap_do', 'ach_do', 'gap_spk', 'ach_spk', 'status']));

            return response()->json(['message' => 'Data berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $data = MonitoringDoSpk::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    private function calculateStatus($data, $type)
    {
        $data->gap_do = $data->act_do - $data->target_do;
        $data->ach_do = ($data->target_do > 0) ? ($data->act_do / $data->target_do) * 100 : 0;
        $data->gap_spk = $data->act_spk - $data->target_spk;
        $data->ach_spk = ($data->target_spk > 0) ? ($data->act_spk / $data->target_spk) * 100 : 0;

        $data->status = ($data->ach_do >= 100) ? StatusMonitoringDoSpk::ON_THE_TRACK : StatusMonitoringDoSpk::PUSH_SPK;
        return $data;
    }
}
