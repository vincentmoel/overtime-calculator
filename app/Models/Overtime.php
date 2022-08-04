<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{

    public function overtimeGroup()
    {
        return $this->belongsTo(OvertimeGroup::class,'overtime_group_id');
    }
}
