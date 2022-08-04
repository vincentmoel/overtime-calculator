<?php

namespace Database\Seeders;

use App\Models\OvertimeGroup;
use Illuminate\Database\Seeder;

class OvertimeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OvertimeGroup::create([
            "user_id"    => 1,
            "month"      => "Agustus",
            "year"       => 2022,
            "name"       => "Ibadah Minggu ke 1",
            "transport"  => "5000",
            "meal"       => "6000",
            "is_sunday"  => true
         ]);

        OvertimeGroup::create([
            "user_id"    => 1,
            "month"      => "Agustus",
            "year"       => 2022,
            "name"       => "Ibadah Minggu ke 2",
            "transport"  => "5000",
            "meal"       => "6000",
            "is_sunday"  => true
         ]);
    }
}
