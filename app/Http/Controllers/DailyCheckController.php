<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\CheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyCheckController extends Controller
{
    //
    public function index()
    {
        return view('checkInOut.scan');
    }

    public function scanQr(Request $request)
    {

        if(now()->format('D') === 'Sat' || now()->format('D') === 'Sun'){
            return response()->json([
                'status' => 'fail',
                'message' => 'Today is Off Day!',
            ]);
        }

        if(date('Y-m-d') !== $request->date){
            return response()->json([
                'status' => 'fail',
                'message' => 'Invalid Qr!',
            ], 200);
        }

        $check_in = CheckIn::firstOrCreate([
            'user_id' => Auth::user()->id,
            'date' => $request->date,
        ]);

        if(!is_null($check_in->check_out) && !is_null($check_in->check_in)){
            return response()->json([
                                'status' => 'fail',
                                'message' => 'Already Check In , out!',
                            ], 200);
        }

        if(is_null($check_in->check_in)){
            $check_in->check_in = Carbon::now()->format('H:i');
            $check_in->update();

            return response()->json([
                'status' => 'success',
                'message' => 'Check In at ' . Carbon::now(),
            ], 200);
        } else {
            if(is_null($check_in->check_out)){
                $check_in->check_out = Carbon::now()->format('H:i');
                $check_in->update();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Check Out at ' . Carbon::now(),
                ], 200);
            }
        }
    }
}
