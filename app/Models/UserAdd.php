<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdd extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cid',
        'organization',
        'dc_id',
        'email',
        'contact',
        'verified',
        'user_id',
        'user_ref_id',
        'client_org',
    ];

    public function user_add_cid()
     {
         return $this->hasMany(UserAddcid::class);
    }
}
