<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->password = Hash::make($model->password); 
        });

        self::updating(function($model){
            $model->password = Hash::make($model->password); 
        });
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function overtimeGroups()
    {
        return $this->hasMany(OvertimeGroup::class);
    }
}
