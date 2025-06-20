<?php

namespace App\Http\Controllers;

use App\Models\SPK;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Response;
use Carbon\Carbon;

class SPKController extends Controller
{
    public function store(Request $request)
    {
        // Check if this is a step validation request
        if ($request->has('validate_step')) {
            return $this->validateStep($request);
        }

        // Final submission logic
        DB::beginTransaction();

        try {
            if ($request->branch_id) {
                $branch = Branch::findOrFail($request->branch_id);
            }

            // Collect all form data from all steps
            $allFormData = $request->data[0] ?? $request->data;

            // Validate all data for final submission
            $rules = [
                'nomor_spk' => 'required|string',
                'customer_name_1' => 'required|string',
                'payment_method' => 'required|string',
                'model' => 'required|string',
                'type' => 'required|string',
                'color' => 'required|string',
                'sales' => 'required|string',
                'branch' => 'required|string',
                'status' => 'required|string',
                'total_payment' => 'required|numeric',
                'customer_type' => 'required|string',
                'fleet' => 'required|string',
                'color_code' => 'required|string',
                'branch_id_text' => 'required|string',
                'type_id' => 'required|string',
                'valid' => 'required|boolean',
                'valid_date' => 'required|date',
                'spk_status' => 'required|string',
                'date_spk' => 'required|date',
                'customer_name_2' => 'required|string',
                'leasing' => 'required|string',
                'supervisor' => 'required|string',
                'custom_type' => 'required|string',
                'date_if_credit_agreement' => 'required|date',
                'po_date' => 'required|date',
                'po_number' => 'required|string',
                'buyer_status' => 'required|string',
                'religion' => 'required|string',
                'province' => 'required|string',
                'city' => 'required|string',
                'district' => 'required|string',
                'sub_district' => 'required|string',
            ];

            $validator = Validator::make($allFormData, $rules);

            if ($validator->fails()) {
                return Response::errorValidate($validator->errors(), 'Validation failed.');
            }

            $data = $validator->validated();
            $data['branch_id'] = $request->branch_id;
            $data['valid'] = $data['valid'] ? 1 : 0;

            SPK::create($data);

            DB::commit();
            return Response::success(null, 'Data SPK berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Data SPK gagal disimpan.');
        }
    }

    private function validateStep(Request $request)
    {
        try {
            $step = $request->step;
            $data = $request->data;

            // Define validation rules for each step - sesuai dengan form create dan edit
            $stepRules = [
                1 => [
                    'customer_name_1' => 'required|string|max:255',
                    'customer_name_2' => 'required|string|max:255',
                    'buyer_status' => 'required|string|max:255',
                    'religion' => 'required|string|max:255',
                    'province' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'district' => 'required|string|max:255',
                    'sub_district' => 'required|string|max:255',
                ],
                2 => [
                    'model' => 'required|string|max:255',
                    'type' => 'required|string|max:255',
                    'color' => 'required|string|max:255',
                    'color_code' => 'required|string|max:255',
                    'fleet' => 'required|string|max:255',
                    'customer_type' => 'required|string|max:255',
                ],
                3 => [
                    'nomor_spk' => 'required|string|max:255',
                    'spk_status' => 'required|string|max:255',
                    'leasing' => 'required|string|max:255',
                    'status' => 'required|string|max:255',
                    'payment_method' => 'required|string|max:255',
                    'total_payment' => 'required|numeric|min:0',
                ],
                4 => [
                    'branch_id_text' => 'required|string|max:255',
                    'branch' => 'required|string|max:255',
                    'sales' => 'required|string|max:255',
                    'supervisor' => 'required|string|max:255',
                    'type_id' => 'required|string|max:255',
                    'custom_type' => 'required|string|max:255',
                ],
                5 => [
                    'valid_date' => 'required|date',
                    'valid' => 'required|in:0,1',
                    'po_number' => 'required|string|max:255',
                    'po_date' => 'required|date',
                    'date_if_credit_agreement' => 'required|date',
                    'date_spk' => 'required|date',
                ],
            ];

            $stepMessages = [
                1 => [
                    'customer_name_1.required' => 'Nama Customer 1 wajib diisi.',
                    'customer_name_1.string' => 'Nama Customer 1 harus berupa teks.',
                    'customer_name_1.max' => 'Nama Customer 1 maksimal 255 karakter.',
                    'customer_name_2.string' => 'Nama Customer 2 harus berupa teks.',
                    'customer_name_2.max' => 'Nama Customer 2 maksimal 255 karakter.',
                    'buyer_status.string' => 'Status pembeli harus berupa teks.',
                    'buyer_status.max' => 'Status pembeli maksimal 255 karakter.',
                    'religion.string' => 'Agama harus berupa teks.',
                    'religion.max' => 'Agama maksimal 255 karakter.',
                    'province.string' => 'Provinsi harus berupa teks.',
                    'province.max' => 'Provinsi maksimal 255 karakter.',
                    'city.string' => 'Kota harus berupa teks.',
                    'city.max' => 'Kota maksimal 255 karakter.',
                    'district.string' => 'Kabupaten harus berupa teks.',
                    'district.max' => 'Kabupaten maksimal 255 karakter.',
                    'sub_district.string' => 'Kecamatan harus berupa teks.',
                    'sub_district.max' => 'Kecamatan maksimal 255 karakter.',
                ],
                2 => [
                    'model.required' => 'Model kendaraan wajib diisi.',
                    'model.string' => 'Model kendaraan harus berupa teks.',
                    'model.max' => 'Model kendaraan maksimal 255 karakter.',
                    'type.required' => 'Tipe kendaraan wajib diisi.',
                    'type.string' => 'Tipe kendaraan harus berupa teks.',
                    'type.max' => 'Tipe kendaraan maksimal 255 karakter.',
                    'color.required' => 'Warna kendaraan wajib diisi.',
                    'color.string' => 'Warna kendaraan harus berupa teks.',
                    'color.max' => 'Warna kendaraan maksimal 255 karakter.',
                    'color_code.required' => 'Kode warna wajib diisi.',
                    'color_code.string' => 'Kode warna harus berupa teks.',
                    'color_code.max' => 'Kode warna maksimal 255 karakter.',
                    'fleet.required' => 'Fleet wajib diisi.',
                    'fleet.string' => 'Fleet harus berupa teks.',
                    'fleet.max' => 'Fleet maksimal 255 karakter.',
                    'customer_type.required' => 'Tipe customer wajib diisi.',
                    'customer_type.string' => 'Tipe customer harus berupa teks.',
                    'customer_type.max' => 'Tipe customer maksimal 255 karakter.',
                ],
                3 => [
                    'nomor_spk.required' => 'Nomor SPK wajib diisi.',
                    'nomor_spk.string' => 'Nomor SPK harus berupa teks.',
                    'nomor_spk.max' => 'Nomor SPK maksimal 255 karakter.',
                    'spk_status.required' => 'Status SPK wajib diisi.',
                    'spk_status.string' => 'Status SPK harus berupa teks.',
                    'spk_status.max' => 'Status SPK maksimal 255 karakter.',
                    'leasing.string' => 'Leasing harus berupa teks.',
                    'leasing.max' => 'Leasing maksimal 255 karakter.',
                    'status.required' => 'Status wajib diisi.',
                    'status.string' => 'Status harus berupa teks.',
                    'status.max' => 'Status maksimal 255 karakter.',
                    'payment_method.required' => 'Metode pembayaran wajib diisi.',
                    'payment_method.string' => 'Metode pembayaran harus berupa teks.',
                    'payment_method.max' => 'Metode pembayaran maksimal 255 karakter.',
                    'total_payment.required' => 'Total pembayaran wajib diisi.',
                    'total_payment.numeric' => 'Total pembayaran harus berupa angka.',
                    'total_payment.min' => 'Total pembayaran tidak boleh negatif.',
                ],
                4 => [
                    'branch_id_text.required' => 'ID cabang wajib diisi.',
                    'branch_id_text.string' => 'ID cabang harus berupa teks.',
                    'branch_id_text.max' => 'ID cabang maksimal 255 karakter.',
                    'branch.required' => 'Nama cabang wajib diisi.',
                    'branch.string' => 'Nama cabang harus berupa teks.',
                    'branch.max' => 'Nama cabang maksimal 255 karakter.',
                    'sales.required' => 'Nama sales wajib diisi.',
                    'sales.string' => 'Nama sales harus berupa teks.',
                    'sales.max' => 'Nama sales maksimal 255 karakter.',
                    'supervisor.string' => 'Supervisor harus berupa teks.',
                    'supervisor.max' => 'Supervisor maksimal 255 karakter.',
                    'type_id.required' => 'ID tipe wajib diisi.',
                    'type_id.string' => 'ID tipe harus berupa teks.',
                    'type_id.max' => 'ID tipe maksimal 255 karakter.',
                    'custom_type.string' => 'Custom type harus berupa teks.',
                    'custom_type.max' => 'Custom type maksimal 255 karakter.',
                ],
                5 => [
                    'valid_date.required' => 'Tanggal valid wajib diisi.',
                    'valid_date.date' => 'Format tanggal valid tidak sesuai.',
                    'valid.required' => 'Status valid wajib dipilih.',
                    'valid.in' => 'Status valid harus berupa 0 atau 1.',
                    'po_number.string' => 'Nomor PO harus berupa teks.',
                    'po_number.max' => 'Nomor PO maksimal 255 karakter.',
                    'po_date.date' => 'Format tanggal PO tidak sesuai.',
                    'date_if_credit_agreement.date' => 'Format tanggal kredit tidak sesuai.',
                    'date_spk.required' => 'Tanggal SPK wajib diisi.',
                    'date_spk.date' => 'Format tanggal SPK tidak sesuai.',
                ],
            ];

            if (!isset($stepRules[$step])) {
                return response()->json([
                    'error' => true,
                    'message' => 'Step tidak valid.',
                    'errors' => ['step' => ['Step tidak valid.']]
                ], 422);
            }

            $rules = $stepRules[$step];
            $messages = $stepMessages[$step] ?? [];

            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }

            return response()->json([
                'error' => false,
                'message' => 'Validasi berhasil!',
                'data' => [
                    'ignore_alert' => true,
                    'step' => (int) ($step + 1),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan validasi.',
                'errors' => ['general' => ['Terjadi kesalahan sistem.']]
            ], 500);
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SPK::query();

            if ($request->branch_id) {
                $data->where('branch_id', $request->branch_id);
            }

            // Date filtering by date_spk
            if ($request->start_date && $request->end_date) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $data->whereBetween('date_spk', [$startDate, $endDate]);
            }

            $listSearch = ['nomor_spk', 'customer_name_1', 'customer_name_2', 'payment_method', 'leasing', 'model', 'type', 'color', 'sales', 'branch', 'status', 'total_payment', 'customer_type', 'fleet', 'color_code', 'branch_id_text', 'type_id', 'valid', 'valid_date', 'custom_type', 'spk_status', 'supervisor', 'date_if_credit_agreement', 'po_date', 'po_number', 'buyer_status', 'religion', 'province', 'city', 'district', 'sub_district'];

            $data = self::filterDatatable($data, $listSearch);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('total_payment', function ($row) {
                    return 'Rp ' . number_format($row->total_payment, 0, ',', '.');
                })
                ->editColumn('date_spk', function ($row) {
                    return $row->date_spk
                        ? Carbon::parse($row->date_spk)->translatedFormat('d F Y')
                        : '-';
                })
                ->addColumn('action', function ($row) {
                    $showButton = '<a href="' . route('spk.show', $row->id_spk) . '" class="inline-block px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600 mr-1">
                        <i class="fas fa-eye"></i> Detail
                    </a>';

                    $editButton = '<a href="' . route('spk.edit', $row->id_spk) . '" class="inline-block px-3 py-1 text-sm text-white bg-green-500 rounded hover:bg-green-600 mr-1">
                        <i class="fas fa-edit"></i> Edit
                    </a>';

                    $deleteButton = '<button class="inline-block px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600 delete"
                        data-id="' . $row->id_spk . '">
                        <i class="fas fa-trash"></i> Delete
                    </button>';

                    return '<div class="flex gap-1">' . $showButton . $editButton . $deleteButton . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $branch = Branch::where('branch_name', $request->branch)->first() ?? Branch::all()->first();
        return view('SPK.index', compact('branch'));
    }

    public function create(Request $request)
    {
        if ($request->has('branch') && $request->branch) {
            $branch = Branch::where('branch_name', $request->branch)->first();
            if (!$branch) {
                $branch = Branch::all()->first();
            }
        } else {
            $branch = Branch::all()->first();
        }

        return view('SPK.create', compact('branch'));
    }

    public function show($id)
    {
        $spk = SPK::findOrFail($id);
        return view('SPK.show', compact('spk'));
    }

    public function edit($id)
    {
        $spk = SPK::findOrFail($id);
        return view('SPK.edit', compact('spk'));
    }

    public function update(Request $request, $id)
    {
        // Check if this is a step validation request for edit form
        if ($request->has('validate_step')) {
            return $this->validateStep($request);
        }

        // Final update submission
        $rules = [
            'nomor_spk' => 'required|string',
            'customer_name_1' => 'required|string',
            'payment_method' => 'required|string',
            'model' => 'required|string',
            'type' => 'required|string',
            'color' => 'required|string',
            'sales' => 'required|string',
            'branch' => 'required|string',
            'status' => 'required|string',
            'total_payment' => 'required|numeric',
            'customer_type' => 'required|string',
            'fleet' => 'required|string',
            'color_code' => 'required|string',
            'branch_id_text' => 'required|string',
            'type_id' => 'required|string',
            'valid' => 'required|boolean',
            'valid_date' => 'required|date',
            'spk_status' => 'required|string',
            'date_spk' => 'required|date',
            'customer_name_2' => 'required|string',
            'leasing' => 'required|string',
            'supervisor' => 'required|string',
            'custom_type' => 'required|string',
            'date_if_credit_agreement' => 'required|date',
            'po_date' => 'required|date',
            'po_number' => 'required|string',
            'buyer_status' => 'required|string',
            'religion' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'sub_district' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::errorValidate($validator->errors(), 'Validation failed.');
        }

        DB::beginTransaction();

        try {
            $spk = SPK::findOrFail($id);
            $data = $validator->validated();
            $data['valid'] = $data['valid'] ? 1 : 0;
            $spk->update($data);

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
