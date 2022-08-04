<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create([
            "name"          => "Jam Kerja Gereja",
            "slug"          => "working-hour",
            "functionality" => "in-form",
            "value"         => 6,
            "description"   => "Untuk Mengurangi Lembur - Jam Kerja"
        ]);

        Config::create([
            "name"          => "Uang Lembur per Jam",
            "slug"          => "money-per-hour",
            "functionality" => "information",
            "value"         => 7000,
            "description"   => "Uang lembur perjam dalam rupiah untuk acuan dalam menghitung uang lembur"
        ]);


    }
}
