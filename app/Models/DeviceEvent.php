<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceEvent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="device_events";
    protected $guarded=[];
}
