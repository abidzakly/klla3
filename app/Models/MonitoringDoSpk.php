<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringDoSpk extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'monitoring_do_spk';
    protected $primaryKey = 'id_monitoring_do_spk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_supervisor',
        'target_do',
        'act_do',
        'gap',
        'ach',
        'target_spk',
        'act_spk',
        'gap_spk',
        'ach_spk',
        'status',
    ];
}
