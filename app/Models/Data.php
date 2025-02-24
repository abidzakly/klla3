<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

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
