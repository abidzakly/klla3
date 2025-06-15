<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPK extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'spk';
    protected $primaryKey = 'id_spk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [
    ];

    protected $casts = [
        'valid' => 'boolean',
        'valid_date' => 'date',
        'date_if_credit_agreement' => 'date',
        'po_date' => 'date',
        'date_spk' => 'datetime',
        'total_payment' => 'decimal:2',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id_branch');
    }
}
