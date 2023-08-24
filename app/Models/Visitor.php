<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cid',
        'client_org',
        'organization',
        'email',
        'contact',
        'reg_id',
        'user_add_id',
        'user_ref_id',
    ];
}
