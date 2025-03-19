<?php

namespace App\Http\Controllers;

use App\Models\SPK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Response;

class SPKController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            if (count($request->data) == 1) {
                $rules = [
                    'data.*.nomor_spk' => 'required|string',
                    'data.*.customer_name_1' => 'required|string',
                    'data.*.customer_name_2' => 'required|string',
                    'data.*.payment_method' => 'required|string',
                    'data.*.leasing' => 'nullable|string',
                    'data.*.model' => 'required|string',
                    'data.*.type' => 'required|string',
                    'data.*.color' => 'required|string',
                    'data.*.sales' => 'required|string',
                    'data.*.branch' => 'required|string',
                    'data.*.status' => 'required|string',
                    'data.*.total_payment' => 'required|numeric',
                    'data.*.customer_type' => 'required|string',
                    'data.*.fleet' => 'required|string',
                    'data.*.color_code' => 'required|string',
                    'data.*.branch_id' => 'required|string',
                    'data.*.type_id' => 'required|string',
                    'data.*.valid' => 'required|boolean',
                    'data.*.valid_date' => 'required|date',
                    'data.*.custom_type' => 'nullable|string',
                    'data.*.spk_status' => 'required|string',
                    'data.*.supervisor' => 'nullable|string',
                    'data.*.date_if_credit_agreement' => 'nullable|date',
                    'data.*.po_date' => 'nullable|date',
                    'data.*.po_number' => 'nullable|string',
                    'data.*.buyer_status' => 'nullable|string',
                    'data.*.religion' => 'nullable|string',
                    'data.*.province' => 'nullable|string',
                    'data.*.city' => 'nullable|string',
                    'data.*.district' => 'nullable|string',
                    'data.*.sub_district' => 'nullable|string',
                ];

                $message = [
                    'data.*.nomor_spk.required' => 'Nomor SPK tidak boleh kosong.',
                    'data.*.customer_name_1.required' => 'Nama Customer 1 tidak boleh kosong.',
                    'data.*.customer_name_2.required' => 'Nama Customer 2 tidak boleh kosong.',
                    'data.*.payment_method.required' => 'Metode Pembayaran tidak boleh kosong.',
                    'data.*.model.required' => 'Model tidak boleh kosong.',
                    'data.*.type.required' => 'Tipe tidak boleh kosong.',
                    'data.*.color.required' => 'Warna tidak boleh kosong.',
                    'data.*.sales.required' => 'Sales tidak boleh kosong.',
                    'data.*.branch.required' => 'Cabang tidak boleh kosong.',
                    'data.*.status.required' => 'Status tidak boleh kosong.',
                    'data.*.total_payment.required' => 'Total Pembayaran tidak boleh kosong.',
                    'data.*.total_payment.numeric' => 'Total Pembayaran harus berupa angka.',
                    'data.*.customer_type.required' => 'Tipe Customer tidak boleh kosong.',
                    'data.*.color_code.required' => 'Kode Warna tidak boleh kosong.',
                    'data.*.branch_id.required' => 'ID Cabang tidak boleh kosong.',
                    'data.*.type_id.required' => 'ID Tipe tidak boleh kosong.',
                    'data.*.valid.required' => 'Valid tidak boleh kosong.',
                    'data.*.valid.boolean' => 'Valid harus berupa boolean.',
                    'data.*.valid_date.required' => 'Tanggal Valid tidak boleh kosong.',
                    'data.*.valid_date.date' => 'Tanggal Valid harus berupa tanggal.',
                    'data.*.spk_status.required' => 'Status SPK tidak boleh kosong.',
                    'data.*.fleet.required' => 'Fleet tidak boleh kosong.',
                ];

                $validator = Validator::make($request->all(), $rules, $message);

                if ($validator->fails()) {
                    return Response::errorValidate($validator->errors(), 'Validation failed.');
                    // return Response::error(null, 'Data SPK gagal disimpan. Pastikan semua data terisi.');
                }
            }

            foreach ($request->data as $key => $row) {
                if ($key == 0 && in_array(null, $row, true)) {
                    continue;
                }

                if (in_array(null, $row)) {
                    return response()->json(['message' => 'Data SPK gagal disimpan. Pastikan semua data terisi.'], 422);
                }

                $row['valid'] = $row['valid'] ? 1 : 0;
                SPK::create($row);
            }

            DB::commit();
            return Response::success(null, 'Data SPK berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Data SPK gagal disimpan.');
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SPK::query();

            $listSearch = ['nomor_spk', 'customer_name_1', 'customer_name_2', 'payment_method', 'leasing', 'model', 'type', 'color', 'sales', 'branch', 'status', 'total_payment', 'customer_type', 'fleet', 'color_code', 'branch_id', 'type_id', 'valid', 'valid_date', 'custom_type', 'spk_status', 'supervisor', 'date_if_credit_agreement', 'po_date', 'po_number', 'buyer_status', 'religion', 'province', 'city', 'district', 'sub_district'];

            $data = self::filterDatatable($data, $listSearch);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nomor_spk', function ($row) {
                    return '<div class="editable" name="nomor_spk">' . $row->nomor_spk . '</div>';
                })
                ->addColumn('customer_name_1', function ($row) {
                    return '<div class="editable" name="customer_name_1">' . $row->customer_name_1 . '</div>';
                })
                ->addColumn('customer_name_2', function ($row) {
                    return '<div class="editable" name="customer_name_2">' . $row->customer_name_2 . '</div>';
                })
                ->addColumn('payment_method', function ($row) {
                    return '<div class="editable" name="payment_method">' . $row->payment_method . '</div>';
                })
                ->addColumn('leasing', function ($row) {
                    return '<div class="editable" name="leasing">' . $row->leasing . '</div>';
                })
                ->addColumn('model', function ($row) {
                    return '<div class="editable" name="model">' . $row->model . '</div>';
                })
                ->addColumn('type', function ($row) {
                    return '<div class="editable" name="type">' . $row->type . '</div>';
                })
                ->addColumn('color', function ($row) {
                    return '<div class="editable" name="color">' . $row->color . '</div>';
                })
                ->addColumn('sales', function ($row) {
                    return '<div class="editable" name="sales">' . $row->sales . '</div>';
                })
                ->addColumn('branch', function ($row) {
                    return '<div class="editable" name="branch">' . $row->branch . '</div>';
                })
                ->addColumn('status', function ($row) {
                    return '<div class="editable" name="status">' . $row->status . '</div>';
                })
                ->addColumn('total_payment', function ($row) {
                    return '<div class="editable" name="total_payment">' . $row->total_payment . '</div>';
                })
                ->addColumn('customer_type', function ($row) {
                    return '<div class="editable" name="customer_type">' . $row->customer_type . '</div>';
                })
                ->addColumn('fleet', function ($row) {
                    return '<div class="editable" name="fleet">' . $row->fleet . '</div>';
                })
                ->addColumn('color_code', function ($row) {
                    return '<div class="editable" name="color_code">' . $row->color_code . '</div>';
                })
                ->addColumn('branch_id', function ($row) {
                    return '<div class="editable" name="branch_id">' . $row->branch_id . '</div>';
                })
                ->addColumn('type_id', function ($row) {
                    return '<div class="editable" name="type_id">' . $row->type_id . '</div>';
                })
                ->addColumn('valid', function ($row) {
                    $checkbox = "<input type='checkbox' class='editable' name='valid' data-id='$row->id_spk' " . ($row->valid ? 'checked' : '') . " readonly disabled>";
                    return '<div class="editable" name="valid" data-current-value="' . $row->valid . '">' . $checkbox . '</div>';
                })
                ->addColumn('valid_date', function ($row) {
                    return '<div class="editable" name="valid_date">' . $row->valid_date . '</div>';
                })
                ->addColumn('custom_type', function ($row) {
                    return '<div class="editable" name="custom_type">' . $row->custom_type . '</div>';
                })
                ->addColumn('spk_status', function ($row) {
                    return '<div class="editable" name="spk_status">' . $row->spk_status . '</div>';
                })
                ->addColumn('supervisor', function ($row) {
                    return '<div class="editable" name="supervisor">' . $row->supervisor . '</div>';
                })
                ->addColumn('date_if_credit_agreement', function ($row) {
                    return '<div class="editable" name="date_if_credit_agreement">' . $row->date_if_credit_agreement . '</div>';
                })
                ->addColumn('po_date', function ($row) {
                    return '<div class="editable" name="po_date">' . $row->po_date . '</div>';
                })
                ->addColumn('po_number', function ($row) {
                    return '<div class="editable" name="po_number">' . $row->po_number . '</div>';
                })
                ->addColumn('buyer_status', function ($row) {
                    return '<div class="editable" name="buyer_status">' . $row->buyer_status . '</div>';
                })
                ->addColumn('religion', function ($row) {
                    return '<div class="editable" name="religion">' . $row->religion . '</div>';
                })
                ->addColumn('province', function ($row) {
                    return '<div class="editable" name="province">' . $row->province . '</div>';
                })
                ->addColumn('city', function ($row) {
                    return '<div class="editable" name="city">' . $row->city . '</div>';
                })
                ->addColumn('district', function ($row) {
                    return '<div class="editable" name="district">' . $row->district . '</div>';
                })
                ->addColumn('sub_district', function ($row) {
                    return '<div class="editable" name="sub_district">' . $row->sub_district . '</div>';
                })
                ->addColumn('action', function ($row) {
                    $editButton = '<button class="flex items-center gap-2 px-4 py-2 text-white transition duration-300 bg-green-500 rounded-lg hover:bg-green-600 edit" 
                        data-id="' . $row->id_spk . '">
                        Edit <i class="ti ti-edit"></i>
                    </button>';

                    $deleteButton = '<button class="flex items-center gap-2 px-4 py-2 text-white transition duration-300 bg-red-500 rounded-lg hover:bg-red-600 delete" 
                        data-id="' . $row->id_spk . '">
                        Delete <i class="ti ti-trash"></i>
                    </button>';

                    return '<div class="flex gap-2 action-buttons">' . $editButton . ' ' . $deleteButton . '</div>';
                })
                ->rawColumns(['nomor_spk', 'customer_name_1', 'customer_name_2', 'payment_method', 'leasing', 'model', 'type', 'color', 'sales', 'branch', 'status', 'total_payment', 'customer_type', 'fleet', 'color_code', 'branch_id', 'type_id', 'valid', 'valid_date', 'custom_type', 'spk_status', 'supervisor', 'date_if_credit_agreement', 'po_date', 'po_number', 'buyer_status', 'religion', 'province', 'city', 'district', 'sub_district', 'action'])
                ->order(function ($query) {
                    if (request()->has('order')) {
                        $order = request('order')[0];
                        $columns = request('columns');
                        $query->orderBy($columns[$order['column']]['data'], $order['dir']);
                    }
                })
                ->make(true);
        }

        return view('spk.index');
    }

    public function create()
    {
        return view('spk.create');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nomor_spk' => 'nullable|string',
            'customer_name_1' => 'nullable|string',
            'customer_name_2' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'leasing' => 'nullable|string',
            'model' => 'nullable|string',
            'type' => 'nullable|string',
            'color' => 'nullable|string',
            'sales' => 'nullable|string',
            'branch' => 'nullable|string',
            'status' => 'nullable|string',
            'total_payment' => 'nullable|numeric',
            'customer_type' => 'nullable|string',
            'fleet' => 'nullable|string',
            'color_code' => 'nullable|string',
            'branch_id' => 'nullable|string',
            'type_id' => 'nullable|string',
            'valid' => 'nullable|boolean',
            'valid_date' => 'nullable|date',
            'custom_type' => 'nullable|string',
            'spk_status' => 'nullable|string',
            'supervisor' => 'nullable|string',
            'date_if_credit_agreement' => 'nullable|date',
            'po_date' => 'nullable|date',
            'po_number' => 'nullable|string',
            'buyer_status' => 'nullable|string',
            'religion' => 'nullable|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'district' => 'nullable|string',
            'sub_district' => 'nullable|string',
        ];

        $message = [
            'nomor_spk.required' => 'Nomor SPK tidak boleh kosong.',
            'customer_name_1.required' => 'Nama Customer 1 tidak boleh kosong.',
            'customer_name_2.required' => 'Nama Customer 2 tidak boleh kosong.',
            'payment_method.required' => 'Metode Pembayaran tidak boleh kosong.',
            'model.required' => 'Model tidak boleh kosong.',
            'type.required' => 'Tipe tidak boleh kosong.',
            'color.required' => 'Warna tidak boleh kosong.',
            'sales.required' => 'Sales tidak boleh kosong.',
            'branch.required' => 'Cabang tidak boleh kosong.',
            'status.required' => 'Status tidak boleh kosong.',
            'total_payment.required' => 'Total Pembayaran tidak boleh kosong.',
            'total_payment.numeric' => 'Total Pembayaran harus berupa angka.',
            'customer_type.required' => 'Tipe Customer tidak boleh kosong.',
            'color_code.required' => 'Kode Warna tidak boleh kosong.',
            'branch_id.required' => 'ID Cabang tidak boleh kosong.',
            'type_id.required' => 'ID Tipe tidak boleh kosong.',
            'valid.required' => 'Valid tidak boleh kosong.',
            'valid.boolean' => 'Valid harus berupa boolean.',
            'valid_date.required' => 'Tanggal Valid tidak boleh kosong.',
            'valid_date.date' => 'Tanggal Valid harus berupa tanggal.',
            'spk_status.required' => 'Status SPK tidak boleh kosong.',
            'fleet.required' => 'Fleet tidak boleh kosong.',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            // return Response::errorValidate($validator->errors(), 'Validation failed.');
            return Response::error(null, 'Data SPK gagal disimpan. Pastikan semua data terisi.');
        }

        DB::beginTransaction();

        try {
            $spk = SPK::findOrFail($id);
            $spk->update($request->all());
            $spk->valid = $request->valid ? 1 : 0;
            $spk->save();

            DB::commit();
            return Response::success(null, 'Data SPK berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Failed to update data.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $spk = SPK::findOrFail($id);
            $spk->delete();

            DB::commit();
            return Response::success(null, 'Data SPK berhasil dihapus.');
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
