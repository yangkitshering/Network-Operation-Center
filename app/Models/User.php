<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    // ... existing model code

    protected $fillable = [
        'name',
        'cid',
        'organization',
        'dc_id',
        'email',
        'contact',
        'password',
        'verified',
        'user_ref_id',
        'status',
        'is_dcfocal',
        'is_thim_dc',
        'is_pling_dc',
        'is_jakar_dc',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected static function booted()
    // {
    //     static::creating(function ($user) {
    //         switch ($user->dc_id) {
    //             case 1:
    //                 $user->is_thim_dc = 1;
    //                 $user->is_pling_dc = 0;
    //                 $user->is_jakar_dc = 0;
    //                 break;
    //             case 2:
    //                 $user->is_thim_dc = 0;
    //                 $user->is_pling_dc = 1;
    //                 $user->is_jakar_dc = 0;
    //                 break;
    //             case 3:
    //                 $user->is_thim_dc = 0;
    //                 $user->is_pling_dc = 0;
    //                 $user->is_jakar_dc = 1;
    //                 break;
    //             // Add more cases if needed
    //         }
    //     });
    // }

    public function cidPhotos()
    {
        return $this->hasMany(CIDFiles::class);
    }
}
