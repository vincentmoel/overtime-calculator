<?php

namespace Database\Seeders;

use App\Models\Overtime;
use Illuminate\Database\Seeder;

class OvertimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Overtime::create([
           "overtime_group_id"  => 1,
           "from"               => "2022-08-01 05:00:00", 
           "to"                 => "2022-08-01 11:00:00",
        ]);
        Overtime::create([
           "overtime_group_id"  => 1,
           "from"               => "2022-08-01 15:00:00", 
           "to"                 => "2022-08-01 18:00:00",
        ]);
        Overtime::create([
           "overtime_group_id"  => 2,
           "from"               => "2022-08-02 05:00:00", 
           "to"                 => "2022-08-02 13:00:00",
        ]);
        Overtime::create([
           "overtime_group_id"  => 2,
           "from"               => "2022-08-02 15:00:00", 
           "to"                 => "2022-08-02 21:00:00",
        ]);
    }
}
