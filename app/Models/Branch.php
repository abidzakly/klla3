<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'branches';
    protected $primaryKey = 'id_branch';
    protected $guarded = [];
    public $timestamps = true;
}
