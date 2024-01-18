<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogParcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'parcel_id',
        'location',
        'activity'
    ];
}
