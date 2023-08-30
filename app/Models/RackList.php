<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RackList extends Model
{
    use HasFactory;
    protected $fillable =[
        'rack_no',
        'rack_name',
        'desc',
        'org_id'
    ];
}
