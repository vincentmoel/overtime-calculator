<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeGroup extends Model
{
    protected $guarded = ['id'];

    protected $with = ['overtimes','user'];


    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
