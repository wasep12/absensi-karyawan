<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mode;

class ModeSeeder extends Seeder
{
    public function run()
    {
        Mode::create([
            'mode' => 1,
            'waktu_masuk' => '08:00',
            'waktu_pulang' => '17:00',
        ]);
    }
}