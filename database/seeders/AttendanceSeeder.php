<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CheckIn;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = User::all();
        foreach ($users as $user) {
            $periods = new CarbonPeriod('2023-07-01' , '2024-07-31');
            foreach ($periods as $period) {
                $attendance = new CheckIn();
                $attendance->user_id = $user->id;
                $attendance->check_in =Carbon::createFromTime(9, rand(1,29))->toTimeString();
                $attendance->check_out =Carbon::createFromTime(18, rand(1,5))->toTimeString();
                $attendance->date = $period->format('Y-m-d');
                $attendance->save();
            }
        }
    }
}
