<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoEventType extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'photo_event_types';
    protected $primaryKey = 'id_photo_event_type';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];
}
