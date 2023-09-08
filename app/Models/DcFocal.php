<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DcFocal extends Model
{
    use HasFactory;
    protected $fillable = [
        'focal_name',
        'focal_contact',
        'focal_email',
        'dc_id',
        'user_id',
    ];
}
