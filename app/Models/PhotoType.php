<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoType extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'photo_types';
    protected $primaryKey = 'id_photo_type';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];
}
