<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cid',
        'email',
        'contact',
        'dc',
        'organization',
        'rack',
        'reason',
        'visitFrom',
        'visitTo',
        'exited',
        'status',
        'requester_ref',
        'passport_path',
        'reject_reason',
        'focal_name',
        'focal_contact',
    ];
}
