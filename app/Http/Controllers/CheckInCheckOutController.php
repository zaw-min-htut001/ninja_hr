<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CheckIn;
use Illuminate\Http\Request;

class CheckInCheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!auth()->user()->can('view_check_in')){
            abort(403 , 'Forbidden');
        }
        return view('checkInOut.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = User::where('pin_code' , $request->pin_code)->first();

        if(!$user){
            return response()->json([
                'status' => 'fail',
                'message' => 'Incorrect Pin code',
            ]);
        }

        $check_in = CheckIn::firstOrCreate([
            'user_id' => $user->id,
            'date' => Carbon::now()->format('Y-m-d'),
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
