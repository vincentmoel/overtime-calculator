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
            "alias"         => "Is Sunday",
            "slug"          => "working_hour",
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
        
        Config::create([
            "name"          => "Uang Transport",
            "alias"         => "Transport",
            "slug"          => "transport_money",
            "functionality" => "in-form",
            "value"         => 5000,
            "description"   => "Uang transport"
        ]);

        Config::create([
            "name"          => "Uang Makan",
            "alias"         => "Meal",
            "slug"          => "meal_money",
            "functionality" => "in-form",
            "value"         => 7000,
            "description"   => "Uang makan"
        ]);


    }
}
