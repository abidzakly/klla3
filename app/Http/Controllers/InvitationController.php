<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Response;

class InvitationController extends Controller
{
    public function store(Request $request)
    {


        DB::beginTransaction();

        try {

            if(count($request->data) == 1){
                $rules = [
                    'data.*.name' => 'required|string',
                    'data.*.address' => 'required|string',
                    'data.*.number_phone' => 'required|string|max:20',
                    'data.*.sales_invitation' => 'required|string',
                ];

                $message = [
                    'data.*.name.required' => 'Nama tidak boleh kosong.',
                    'data.*.address.required' => 'Alamat tidak boleh kosong.',
                    'data.*.number_phone.required' => 'Nomor Telepon tidak boleh kosong.',
                    'data.*.number_phone.max' => 'Nomor Telepon maksimal 20 karakter.',
                    'data.*.sales_invitation.required' => 'Sales Undangan tidak boleh kosong.',
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
            $data = Invitation::query();

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
                ->rawColumns(['name', 'address', 'number_phone', 'sales_invitation', 'action'])
                ->order(function ($query) {
                    if (request()->has('order')) {
                        $order = request('order')[0];
                        $columns = request('columns');
                        $query->orderBy($columns[$order['column']]['data'], $order['dir']);
                    }
                })
                ->make(true);
        }

        return view('invitation.index');
    }

    public function create()
    {
        return view('invitation.create');
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
