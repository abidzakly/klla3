<?php

namespace App\Http\Controllers;

use App\Enums\MonitoringType;
use App\Enums\StatusMonitoringDoSpk;
use App\Models\MonitoringDoSpk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\MonitoringDoSpkExport;

class MonitoringDoSpkController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MonitoringDoSpk::query()
                ->join('supervisors', 'monitoring_do_spk.id_supervisor', '=', 'supervisors.id_supervisor')
                ->select(
                    'monitoring_do_spk.id_monitoring_do_spk',
                    'monitoring_do_spk.id_supervisor',
                    'supervisors.supervisor_name as nama_supervisor',
                    'monitoring_do_spk.productivity',
                    'monitoring_do_spk.mpp',
                    'monitoring_do_spk.target_do',
                    'monitoring_do_spk.act_do',
                    'monitoring_do_spk.gap_do',
                    'monitoring_do_spk.ach_do',
                    'monitoring_do_spk.target_spk',
                    'monitoring_do_spk.act_spk',
                    'monitoring_do_spk.gap_spk',
                    'monitoring_do_spk.ach_spk',
                    'monitoring_do_spk.status',
                    'monitoring_do_spk.date'
                );

            if ($request->date) {
                $data->where('monitoring_do_spk.date', $request->date);
            }
            // if ($request->start_date && $request->end_date) {
            //     $data->whereBetween('date', [$request->start_date, $request->end_date]);
            // } elseif ($request->start_date) {
            //     $data->where('date', '>=', $request->start_date);
            // } elseif ($request->end_date) {
            //     $data->where('date', '<=', $request->end_date);
            // }

            $listSearch = [
                'nama_supervisor' => ['nama_supervisor'],
                'target_do' => ['target_do'],
                'act_do' => ['act_do'],
                'mpp' => ['mpp'],
                'gap_do' => ['gap_do'],
                'ach_do' => ['ach_do'],
                'productivity' => ['productivity'],
                'status' => ['status'],
                'target_spk' => ['target_spk'],
                'act_spk' => ['act_spk'],
                'gap_spk' => ['gap_spk'],
                'ach_spk' => ['ach_spk'],
                'created_at' => ['created_at'],
                'updated_at' => ['updated_at'],
                'date' => ['date'],
            ];

            $data = self::filterDatatable($data, $listSearch);

            return DataTables::of($data)
                ->addColumn('nama_supervisor', function ($row) {
                    return '<div class="editable" data-name="nama_supervisor">'
                        . $row->nama_supervisor .
                        "<input type='hidden' data-name='id_supervisor' value='" . $row->id_supervisor . "'>" .
                        '</div>';
                })
                ->addColumn('act_do', function ($row) {
                    return '<div class="editable" data-name="act_do">' . $row->act_do . '</div>';
                })
                ->addColumn('target_do', function ($row) {
                    return '<div class="editable" data-name="target_do">' . $row->target_do . '</div>';
                })
                ->addColumn('mpp', function ($row) {                    
                    return '<div class="editable" data-name="mpp">' . $row->mpp . '</div>';
                })
                ->addColumn('gap_do', function ($row) {
                    $format = $row->gap_do ? round($row->gap_do) : 0;
                    return '<div class="editable" data-name="gap_do">' . $format . '</div>';
                })
                ->addColumn('ach_do', function ($row) {
                    $format = $row->ach_do ? round($row->ach_do) . '%' : 0;
                    return '<div class="editable" data-name="ach_do">' . $format . '</div>';
                })                
                ->addColumn('productivity', function ($row) {
                    $format = $row->productivity ? round($row->productivity) . '%' : 0;
                    return '<div class="editable" data-name="productivity">' . $format . '</div>';
                })
                ->addColumn('target_spk', function ($row) {
                    return '<div class="editable" data-name="target_spk">' . $row->target_spk . '</div>';
                })               
                ->addColumn('act_spk', function ($row) {
                    return '<div class="editable" data-name="act_spk">' . $row->act_spk . '</div>';
                })                                
                ->addColumn('gap_spk', function ($row) {
                    $format = $row->gap_spk ? round($row->gap_spk) : 0;
                    return '<div class="editable" data-name="gap_spk">' . $format . '</div>';
                })
                ->addColumn('ach_spk', function ($row) {
                    $format = $row->ach_spk ? round($row->ach_spk) . '%' : 0;
                    return '<div class="editable" data-name="ach_spk">' . $format . '</div>';
                })
                ->addColumn('status', function ($row) {
                    $statusColors = [
                        StatusMonitoringDoSpk::ON_THE_TRACK => 'bg-green-500',
                        StatusMonitoringDoSpk::PUSH_SPK => 'bg-red-500',
                    ];

                    $colorClass = $statusColors[$row->status] ?? 'bg-gray-500';

                    return '<p class="px-3 py-1 mx-auto text-center text-white rounded-lg status_text text-nowrap ' . $colorClass . '" style="min-width: 140px;width: 140px">
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

                    return '<div class="flex items-center justify-center gap-2 action-buttons">' . $editButton . ' ' . $deleteButton . '</div>';
                })
                ->rawColumns(['nama_supervisor', 'target_do', 'act_do', 'gap_do', 'ach_do', 'target_spk', 'act_spk', 'gap_spk', 'ach_spk', 'status', 'action' , 'mpp', 'productivity'])
                ->order(function ($query) {
                    if (request()->has('order')) {
                        $order = request('order')[0];
                        $columns = request('columns');
                        $query->orderBy($columns[$order['column']]['data'], $order['dir']);
                    }
                })
                ->make(true);
        }

        $lastTypeInput = MonitoringDoSpk::orderBy('created_at', 'desc')->first();

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
                'data.0.id_supervisor' => 'required|exists:supervisors,id_supervisor',
                'data.0.id_monitoring_do_spk' => 'nullable|exists:monitoring_do_spk,id_monitoring_do_spk',
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
                    'data.0.mpp' => 'required|integer',
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
                return response()->json(['message' => 'Data ' . $request->type . ' gagal disimpan. Pastikan semua data terisi.'], 422);
            }
        }

        DB::beginTransaction();

        try {
            $date = $request->date;
            foreach ($request->data as $row) {
                // Validasi: jika salah satu terisi tapi pasangannya tidak, tolak
                $isDO = $request->type === 'DO';
                $isSPK = $request->type === 'SPK';

                $target = $isDO ? $row['target_do'] : $row['target_spk'];
                $actual = $isDO ? $row['act_do'] : $row['act_spk'];
                $mpp    = $isDO ? ($row['mpp'] ?? null) : null; // mpp hanya untuk DO

                // Jika semua kosong, skip
                if ($target === null && $actual === null && ($isSPK || $mpp === null)) {
                    continue;
                }

                // Validasi: jika salah satu terisi tapi tidak semuanya
                if (
                    ($isDO && ($target === null || $actual === null || $mpp === null)) ||
                    ($isSPK && ($target === null || $actual === null))
                ) {
                    return response()->json([
                        'message' => 'Data ' . $request->type . ' gagal disimpan. Pastikan semua data terisi.'
                    ], 422);
                }

                // Cek apakah sudah ada data untuk supervisor dan tanggal ini
                $monitoring = null;
                if (!empty($row['id_monitoring_do_spk'])) {
                    $monitoring = MonitoringDoSpk::where('id_monitoring_do_spk', $row['id_monitoring_do_spk'])->first();
                }                

                if ($request->type == 'DO') {
                    if ($monitoring) {
                        $monitoring->target_do = $row['target_do'];
                        $monitoring->act_do = $row['act_do'];
                        $monitoring->mpp = $row['mpp'];
                    } else {
                        $monitoring = new MonitoringDoSpk([
                            'id_supervisor' => $row['id_supervisor'],
                            'target_do' => $row['target_do'],
                            'act_do' => $row['act_do'],
                            'date' => $date,
                        ]);
                    }
                } elseif ($request->type == 'SPK') {
                    if ($monitoring) {
                        $monitoring->target_spk = $row['target_spk'];
                        $monitoring->act_spk = $row['act_spk'];
                    } else {
                        $monitoring = new MonitoringDoSpk([
                            'id_supervisor' => $row['id_supervisor'],
                            'target_spk' => $row['target_spk'],
                            'act_spk' => $row['act_spk'],
                            'date' => $date,
                        ]);
                    }
                }

                $this->calculateStatus($monitoring, $request->type);
                $monitoring->date = $date;
                $monitoring->save();
            }

            DB::commit();
            return response()->json(['message' => 'Data ' . $request->type . ' berhasil disimpan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'file' => $e->getTrace(), 'line' => $e->getLine()], 500);
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
                'mpp' => 'nullable|integer',
                'target_spk' => 'nullable|integer',
                'act_spk' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $dataUodate = new MonitoringDoSpk($request->only(['nama_supervisor', 'target_do', 'act_do', 'target_spk', 'act_spk', 'mpp']));
            $dataUpdate = $this->calculateStatus($dataUodate, 'all');
            $data->update($dataUpdate->only(['nama_supervisor', 'target_do', 'act_do', 'target_spk', 'act_spk', 'gap_do', 'ach_do', 'gap_spk', 'ach_spk', 'status' , 'mpp', 'productivity']));

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
        $data->productivity = ($data->act_do > 0) ? ($data->mpp / $data->act_do) * 100 : 0;

        $data->status = ($data->ach_do >= 100) ? StatusMonitoringDoSpk::ON_THE_TRACK : StatusMonitoringDoSpk::PUSH_SPK;
        return $data;
    }

    public function export(Request $request)
    {
        $query = MonitoringDoSpk::query()
            ->join('supervisors', 'monitoring_do_spk.id_supervisor', '=', 'supervisors.id_supervisor')
            ->select(
                'monitoring_do_spk.id_monitoring_do_spk',
                'monitoring_do_spk.id_supervisor',
                'supervisors.supervisor_name as nama_supervisor',
                'monitoring_do_spk.target_do',
                'monitoring_do_spk.act_do',
                'monitoring_do_spk.gap_do',
                'monitoring_do_spk.ach_do',
                'monitoring_do_spk.target_spk',
                'monitoring_do_spk.act_spk',
                'monitoring_do_spk.gap_spk',
                'monitoring_do_spk.ach_spk',
                'monitoring_do_spk.status',
                'monitoring_do_spk.date'
            );

        // if ($request->start_date && $request->end_date) {
        //     $query->whereBetween('date', [$request->start_date, $request->end_date]);
        // } elseif ($request->start_date) {
        //     $query->where('date', '>=', $request->start_date);
        // } elseif ($request->end_date) {
        //     $query->where('date', '<=', $request->end_date);
        // }



        $data = $query->get()->map(function ($item) {
            $item->date = $item->date ? date('d-M-Y', strtotime($item->date)) : null;
            return $item;
        });

        if ($request->date) {
            $data->where('monitoring_do_spk.date', $request->date);
        }

        $data->toArray();

        $export = new MonitoringDoSpkExport($data);
        return $export->download();
    }
}
