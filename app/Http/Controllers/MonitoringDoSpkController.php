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
                    $format = number_format($row->ach_do, 2);
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
                    $format = number_format($row->ach_spk, 2);
                    return '<div class="editable" data-name="ach_spk">' . $format . '</div>';
                })
                ->addColumn('status', function ($row) {
                    return '<div class="editable" data-name="status">' . $row->status . '</div>';
                })
                ->addColumn('action', function ($row) {
                    $editButton = '<button class="edit btn btn-success btn-sm" data-id="' . $row->id_monitoring_do_spk . '"><i class="ti ti-edit"></i></button>';
                    $deleteButton = '<button class="delete btn btn-danger btn-sm" data-id="' . $row->id_monitoring_do_spk . '"><i class="ti ti-trash"></i></button>';
                    return '<div class="action-buttons" style="display: flex; gap: 0.5rem;">' . $editButton . ' ' . $deleteButton . '</div>';
                })
                ->rawColumns(['nama_supervisor', 'target_do', 'act_do', 'gap_do', 'ach_do', 'target_spk', 'act_spk', 'gap_spk', 'ach_spk', 'status', 'action'])
                ->make(true);
        }

        return view('dashboard');
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
        $validator = Validator::make($request->all(), [
            'nama_supervisor' => 'required|string',
            'target_do' => 'nullable|integer',
            'act_do' => 'nullable|integer',
            'gap_do' => 'nullable|numeric',
            'ach_do' => 'nullable|numeric',
            'target_spk' => 'nullable|integer',
            'act_spk' => 'nullable|integer',
            'gap_spk' => 'nullable|numeric',
            'ach_spk' => 'nullable|numeric',
            'status' => 'nullable|string',
            'type' => 'required|in:' . implode(',', MonitoringType::values()),
        ]);

        if ($request->type === MonitoringType::DO) {
            $validator->after(function ($validator) {
                $validator->addRules([
                    'target_do' => 'required|integer',
                    'act_do' => 'required|integer',
                    'gap_do' => 'required|numeric',
                    'ach_do' => 'required|numeric',
                ]);
            });
        } elseif ($request->type === MonitoringType::SPK) {
            $validator->after(function ($validator) {
                $validator->addRules([
                    'target_spk' => 'required|integer',
                    'act_spk' => 'required|integer',
                    'gap_spk' => 'required|numeric',
                    'ach_spk' => 'required|numeric',
                ]);
            });
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $namaSupervisor = strtolower($request->nama_supervisor);

        DB::beginTransaction();

        try {
            $existingData = MonitoringDoSpk::whereRaw('LOWER(nama_supervisor) = ?', [$namaSupervisor])
                ->orderBy('created_at', 'asc');

            if ($request->type === MonitoringType::DO) {
                $existingData->where('ach_do', null);
            } elseif ($request->type === MonitoringType::SPK) {
                $existingData->where('ach_spk', null);
            }

            $existingData = $existingData->first();

            if ($existingData) {
                if ($request->type === MonitoringType::DO) {
                    if ($existingData->ach_do) {
                        // Create new record if SPK data already exists
                        $data = MonitoringDoSpk::create($request->all());
                    } else {
                        // Update existing record
                        $existingData->update($request->only(['target_do', 'act_do', 'gap_do', 'ach_do']));
                        $data = $existingData;
                    }
                } elseif ($request->type === MonitoringType::SPK) {
                    if ($existingData->ach_spk) {
                        // Create new record if DO data already exists
                        $data = MonitoringDoSpk::create($request->all());
                    } else {
                        // Update existing record
                        $existingData->update($request->only(['target_spk', 'act_spk', 'gap_spk', 'ach_spk']));
                        $data = $existingData;
                    }
                }
            } else {
                // Create new record if no existing data
                $data = MonitoringDoSpk::create($request->all());
            }

            $this->calculateStatus($data, $request->type);
            DB::commit();
            return response()->json(['message' => 'Data ' . $request->type . ' created successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = MonitoringDoSpk::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_supervisor' => 'required|string',
            'target_do' => 'required|integer',
            'act_do' => 'required|integer',
            'target_spk' => 'required|integer',
            'act_spk' => 'required|integer',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data->update($request->only(['nama_supervisor', 'target_do', 'act_do', 'target_spk', 'act_spk', 'status']));
        $this->calculateStatus($data, $request->type);

        return response()->json(['message' => 'Data updated successfully.']);
    }

    public function destroy($id)
    {
        $data = MonitoringDoSpk::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Data deleted successfully.']);
    }

    private function calculateStatus($data, $type)
    {
        if ($type === MonitoringType::DO || $data->ach_spk === null) {
            $data->gap_do = $data->act_do - $data->target_do;
            $data->ach_do = ($data->target_do > 0) ? ($data->act_do / $data->target_do) * 100 : 0;
        } elseif ($type === MonitoringType::SPK || $data->ach_do === null) {
            $data->gap_spk = $data->act_spk - $data->target_spk;
            $data->ach_spk = ($data->target_spk > 0) ? ($data->act_spk / $data->target_spk) * 100 : 0;
        }

        $data->status = ($data->ach_do >= 100) ? StatusMonitoringDoSpk::ON_THE_TRACK : StatusMonitoringDoSpk::PUSH_SPK;
        $data->save();
    }
}
