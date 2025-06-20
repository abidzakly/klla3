<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SPKStepValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $validate = [
            'step' => ['required', 'integer', 'min:1', 'max:5']
        ];

        if (isset($this->step)) {
            switch ($this->step) {
                case 5:
                    $addValidate = [
                        'data.valid_date' => ['required', 'date'],
                        'data.valid' => ['required', 'boolean'],
                        'data.po_number' => ['nullable', 'string', 'max:255'],
                        'data.po_date' => ['nullable', 'date'],
                        'data.date_if_credit_agreement' => ['nullable', 'date'],
                        'data.date_spk' => ['required', 'date'],
                    ];
                    $validate = array_merge($validate, $addValidate);
                case 4:
                    $addValidate = [
                        'data.branch_id_text' => ['required', 'string', 'max:255'],
                        'data.branch' => ['required', 'string', 'max:255'],
                        'data.sales' => ['required', 'string', 'max:255'],
                        'data.supervisor' => ['nullable', 'string', 'max:255'],
                        'data.type_id' => ['required', 'string', 'max:255'],
                        'data.custom_type' => ['nullable', 'string', 'max:255'],
                    ];
                    $validate = array_merge($validate, $addValidate);
                case 3:
                    $addValidate = [
                        'data.nomor_spk' => ['required', 'string', 'max:255'],
                        'data.spk_status' => ['required', 'string', 'max:255'],
                        'data.leasing' => ['nullable', 'string', 'max:255'],
                        'data.status' => ['required', 'string', 'max:255'],
                        'data.payment_method' => ['required', 'string', 'max:255'],
                        'data.total_payment' => ['required', 'numeric', 'min:0'],
                    ];
                    $validate = array_merge($validate, $addValidate);
                case 2:
                    $addValidate = [
                        'data.model' => ['required', 'string', 'max:255'],
                        'data.type' => ['required', 'string', 'max:255'],
                        'data.color' => ['required', 'string', 'max:255'],
                        'data.color_code' => ['required', 'string', 'max:255'],
                        'data.fleet' => ['required', 'string', 'max:255'],
                        'data.customer_type' => ['required', 'string', 'max:255'],
                    ];
                    $validate = array_merge($validate, $addValidate);
                case 1:
                    $addValidate = [
                        'data.customer_name_1' => ['required', 'string', 'max:255'],
                        'data.customer_name_2' => ['nullable', 'string', 'max:255'],
                        'data.buyer_status' => ['nullable', 'string', 'max:255'],
                        'data.religion' => ['nullable', 'string', 'max:255'],
                        'data.province' => ['nullable', 'string', 'max:255'],
                        'data.city' => ['nullable', 'string', 'max:255'],
                        'data.district' => ['nullable', 'string', 'max:255'],
                        'data.sub_district' => ['nullable', 'string', 'max:255'],
                    ];
                    $validate = array_merge($validate, $addValidate);
                default:
                    break;
            }
        }

        return $validate;
    }

    public function messages(): array
    {
        return [
            // Step 1 messages
            'data.customer_name_1.required' => 'Nama Customer 1 wajib diisi.',
            'data.customer_name_1.string' => 'Nama Customer 1 harus berupa teks.',
            'data.customer_name_1.max' => 'Nama Customer 1 maksimal 255 karakter.',

            // Step 2 messages
            'data.model.required' => 'Model kendaraan wajib diisi.',
            'data.type.required' => 'Tipe kendaraan wajib diisi.',
            'data.color.required' => 'Warna kendaraan wajib diisi.',
            'data.color_code.required' => 'Kode warna wajib diisi.',
            'data.fleet.required' => 'Fleet wajib diisi.',
            'data.customer_type.required' => 'Tipe customer wajib diisi.',

            // Step 3 messages
            'data.nomor_spk.required' => 'Nomor SPK wajib diisi.',
            'data.spk_status.required' => 'Status SPK wajib diisi.',
            'data.status.required' => 'Status wajib diisi.',
            'data.payment_method.required' => 'Metode pembayaran wajib diisi.',
            'data.total_payment.required' => 'Total pembayaran wajib diisi.',
            'data.total_payment.numeric' => 'Total pembayaran harus berupa angka.',
            'data.total_payment.min' => 'Total pembayaran tidak boleh negatif.',

            // Step 4 messages
            'data.branch_id_text.required' => 'ID cabang wajib diisi.',
            'data.branch.required' => 'Nama cabang wajib diisi.',
            'data.sales.required' => 'Nama sales wajib diisi.',
            'data.type_id.required' => 'ID tipe wajib diisi.',

            // Step 5 messages
            'data.valid_date.required' => 'Tanggal valid wajib diisi.',
            'data.valid_date.date' => 'Format tanggal valid tidak sesuai.',
            'data.valid.required' => 'Status valid wajib dipilih.',
            'data.valid.boolean' => 'Status valid harus berupa ya/tidak.',
            'data.date_spk.required' => 'Tanggal SPK wajib diisi.',
            'data.date_spk.date' => 'Format tanggal SPK tidak sesuai.',
        ];
    }
}

