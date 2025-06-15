<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Response;
use App\Models\Branch;
use Carbon\Carbon;

class InvitationController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $branch = Branch::findOrFail($request->branch_id);

            if(count($request->data) == 1){
                $rules = [
                    'branch_id' => 'required|exists:branches,id_branch',
                    'data.*.name' => 'required|string',
                    'data.*.address' => 'required|string',
                    'data.*.number_phone' => 'required|string|max:20',
                    'data.*.sales_invitation' => 'required|string',
                    'data.*.invitation_date' => 'required|date',
                ];

                $message = [
                    'branch_id.required' => 'Cabang harus dipilih.',
                    'branch_id.exists' => 'Cabang tidak valid.',
                    'data.*.name.required' => 'Nama tidak boleh kosong.',
                    'data.*.address.required' => 'Alamat tidak boleh kosong.',
                    'data.*.number_phone.required' => 'Nomor Telepon tidak boleh kosong.',
                    'data.*.number_phone.max' => 'Nomor Telepon maksimal 20 karakter.',
                    'data.*.sales_invitation.required' => 'Sales Undangan tidak boleh kosong.',
                    'data.*.invitation_date.required' => 'Tanggal undangan harus diisi.',
                    'data.*.invitation_date.date' => 'Format tanggal undangan tidak valid.',
                ];

                $validator = Validator::make($request->all(), $rules, $message);

                if ($validator->fails()) {
                    return Response::errorValidate($validator->errors(), 'Validation failed.');
                }
            }

            foreach ($request->data as $key => $row) {
                if ($key == 0 && in_array(null, $row, true)) {
                    continue;
                }

                if (in_array(null, $row) && count($request->data) > 1) {
                    return response()->json(['message' => 'Data undangan gagal disimpan. Pastikan semua data terisi.'], 422);
                }

                $row['branch_id'] = $request->branch_id;
                Invitation::create($row);
            }

            DB::commit();
            return Response::success(null, 'Data Undangan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Data undangan gagal disimpan.');
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Invitation::with('branch')->where('branch_id', $request->branch_id);

            // Date filtering by invitation_date
            if ($request->start_date && $request->end_date) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $data->whereBetween('invitation_date', [$startDate, $endDate]);
            }

            $listSearch = ['name', 'address', 'number_phone', 'sales_invitation'];
            $data = self::filterDatatable($data, $listSearch);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return '<div class="editable" name="name">' . $row->name . '</div>';
                })
                ->addColumn('address', function ($row) {
                    return '<textarea class="editable-textarea editable" name="address" readonly>' . $row->address . '</textarea>';
                })
                ->addColumn('number_phone', function ($row) {
                    return '<div class="editable" name="number_phone">' . $row->number_phone . '</div>';
                })
                ->addColumn('sales_invitation', function ($row) {
                    return '<div class="editable" name="sales_invitation">' . $row->sales_invitation . '</div>';
                })
                ->addColumn('action', function ($row) {
                    $editButton = '<button class="flex items-center gap-2 px-4 py-2 text-white transition duration-300 bg-green-500 rounded-lg hover:bg-green-600 edit"
                        data-id="' . $row->id_invitation . '">
                        Edit <i class="ti ti-edit"></i>
                    </button>';

                    $deleteButton = '<button class="flex items-center gap-2 px-4 py-2 text-white transition duration-300 bg-red-500 rounded-lg hover:bg-red-600 delete"
                        data-id="' . $row->id_invitation . '">
                        Delete <i class="ti ti-trash"></i>
                    </button>';

                    return '<div class="flex gap-2 action-buttons">' . $editButton . ' ' . $deleteButton . '</div>';
                })
                ->order(function ($query) {
                    if (request()->has('order')) {
                        $order = request('order')[0];
                        $columns = request('columns');
                        $query->orderBy($columns[$order['column']]['data'], $order['dir']);
                    }
                })
                ->rawColumns(['name', 'address', 'number_phone', 'sales_invitation', 'action'])
                ->make(true);
        }

        $branch = Branch::where('branch_name', $request->branch)->first() ?? Branch::all()->first();
        return view('invitation.index', compact('branch'));
    }

    public function create(Request $request)
    {
        // Jika ada parameter branch, cari berdasarkan nama branch
        // Jika tidak ada atau tidak ditemukan, gunakan branch yang pertama
        if ($request->has('branch') && $request->branch) {
            $branch = Branch::where('branch_name', $request->branch)->first();
            if (!$branch) {
                $branch = Branch::all()->first();
            }
        } else {
            $branch = Branch::all()->first();
        }

        return view('invitation.create', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string',
            'address' => 'required|string',
            'number_phone' => 'required|string|max:20',
            'sales_invitation' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::errorValidate($validator->errors(), 'Validation failed.');
        }

        DB::beginTransaction();

        try {
            $invitation = Invitation::findOrFail($id);
            $invitation->update($request->all());

            DB::commit();
            return Response::success(null, 'Data Undangan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Failed to update data.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $invitation = Invitation::findOrFail($id);
            $invitation->delete();

            DB::commit();
            return Response::success(null, 'Data Undangan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Failed to delete data.');
        }
    }

    private static function filterDatatable($query, $searchColumns)
    {
        $searchValue = request('search.value');
        if ($searchValue) {
            $query->where(function ($query) use ($searchColumns, $searchValue) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $searchValue . '%');
                }
            });
        }
        return $query;
    }
}
