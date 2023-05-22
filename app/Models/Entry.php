<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    const CREATED_AT = 'entry_at';
    const UPDATED_AT = 'exit_at';

    protected $fillable = [
        'name',
        'empID',
        'email',
        'dept',
        'section',
        'reason',
    ];
}
