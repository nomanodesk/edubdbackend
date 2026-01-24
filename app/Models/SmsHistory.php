<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'institution_id',
        'phone',
        'operator',
        'message',
        'status',
        'response'
    ];
}
