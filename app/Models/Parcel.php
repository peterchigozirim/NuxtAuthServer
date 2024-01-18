<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'sender_name',
        'recepient',
        'recepient_email',
        'recepient_phone',
        'recepient_address',
        'recepient_country',
        'parcel_description',
        'logitsic_type',
        'weight',
        'location',
        'status',
        'total_days',
        'deputuer_day',
        'arrival_day'
    ];
}
