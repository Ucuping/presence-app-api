<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shift::insert([
            [
                'name' => 'Shift 1',
                'start_entry' => '06:00:00',
                'start_time_entry' => '08:00:00',
                'start_exit' => '13:00:00',
                'start_time_exit' => '14:00:00',
            ],
            [
                'name' => 'Shift 2',
                'start_entry' => '09:00:00',
                'start_time_entry' => '11:00:00',
                'start_exit' => '15:00:00',
                'start_time_exit' => '16:00:00',
            ],
        ]);
    }
}
