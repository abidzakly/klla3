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

    protected $guarded = [];
}
