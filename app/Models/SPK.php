<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SPK extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'spk';
    protected $primaryKey = 'id_spk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nomor_spk',
        'customer_name_1',
        'customer_name_2',
        'payment_method',
        'leasing',
        'model',
        'type',
        'color',
        'sales',
        'branch',
        'status',
        'total_payment',
        'customer_type',
        'fleet',
        'color_code',
        'branch_id_text',
        'type_id',
        'valid',
        'valid_date',
        'custom_type',
        'spk_status',
        'supervisor',
        'date_if_credit_agreement',
        'po_date',
        'po_number',
        'buyer_status',
        'religion',
        'province',
        'city',
        'district',
        'sub_district',
        'date_spk',
    ];

    protected $casts = [
        'valid' => 'boolean',
        'valid_date' => 'date',
        'date_if_credit_agreement' => 'date',
        'po_date' => 'date',
        'date_spk' => 'date',
        'total_payment' => 'decimal:2',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id_text', 'id_branch');
    }
}
