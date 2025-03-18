<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'invitations';
    protected $primaryKey = 'id_invitation';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];
}
