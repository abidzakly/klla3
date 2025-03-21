<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoEvent extends Model
{
    use HasFactory, HasUlids;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id_photo_event';
    protected $table = 'photo_events';

    protected $guarded = [

    ];

    public function photoEventType()
    {
        return $this->belongsTo(PhotoEventType::class, 'photo_event_type_id', 'id_photo_event_type');
    }

    public function getImage()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileName()
    {
        return pathinfo($this->file_path, PATHINFO_FILENAME);
    }
}
