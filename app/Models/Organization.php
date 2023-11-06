<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        'org_name',
        'org_address',
        'dc_id',
        'is_thim_dc',
        'is_pling_dc',
        'is_jakar_dc',
        
    ];
    
}

