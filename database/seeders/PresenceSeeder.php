<?php

namespace Database\Seeders;

use App\Models\Presence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Presence::insert([
            [
                'user_id' => 1,
                'shift_id' => 1,
                'date' => '2020-05-03',
                'type' => 'checkin',
                'time_in' => '06:00:00',
                'latitude' => '-6.91748',
                'longitude' => '107.61942',
                'description' => 'Masuk',
            ],
            [
                'user_id' => 1,
                'shift_id' => 1,
                'date' => '2020-05-03',
                'type' => 'checkout',
                'time_in' => '14:00:00',
                'latitude' => '-6.91748',
                'longitude' => '107.61942',
                'description' => 'Pulang',
            ],
            [
                'user_id' => 2,
                'shift_id' => 2,
                'date' => '2020-05-03',
                'type' => 'checkin',
                'time_in' => '12:00:00',
                'latitude' => '-6.91748',
                'longitude' => '107.61942',
                'description' => 'Terlambat',
            ],
        ]);
    }
}
