<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $guarded = ['id'];

    public function overtimeGroup()
    {
        return $this->belongsTo(OvertimeGroup::class,'overtime_group_id');
    }
}
