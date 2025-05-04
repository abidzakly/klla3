<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;

class MonitoringDoSpk extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'monitoring_do_spk';
    protected $primaryKey = 'id_monitoring_do_spk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $cast = [
        'date' => 'date',
    ];

    protected $fillable = [
        'id_supervisor',
        'target_do',
        'act_do',
        'gap_do',
        'ach_do',
        'mpp',
        'productivity',
        'target_spk',
        'act_spk',
        'gap_spk',
        'ach_spk',
        'status',
        'date',
    ];

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'id_supervisor', 'supervisor_id');
    }

    // public function getAchDoAttribute($value)
    // {
    //     return round($value);
    // }

    // public function getGapDoAttribute($value)
    // {
    //     return round($value);
    // }

    // public function getAchSpkAttribute($value)
    // {
    //     return round($value);
    // }

    // public function getGapSpkAttribute($value)
    // {
    //     return round($value);
    // }

    public function getAchDoAttribute($value)
    {
        return round($value, 2);
    }

    public function getGapDoAttribute($value)
    {
        return round($value, 2);
    }

    public function getAchSpkAttribute($value)
    {
        return round($value, 2);
    }

    public function getGapSpkAttribute($value)
    {
        return round($value, 2);
    }

    // public function getGapDoRound()
    // {
    //     return round($this->gap_do);
    // }

    // public function getAchDoRound()
    // {
    //     return round($this->ach_do);
    // }

    // public function getGapSpkRound()
    // {
    //     return round($this->gap_spk);
    // }

    // public function getAchSpkRound()
    // {
    //     return round($this->ach_spk);
    // }
}
