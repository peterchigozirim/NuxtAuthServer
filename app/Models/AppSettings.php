<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'app_short_name',
        'app_email',
        'app_phone',
        'app_address',
        'app_description',
    ];
}
