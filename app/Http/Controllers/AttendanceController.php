<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CheckIn;
use App\Models\Company;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->can('view_attendance')){
            abort(403 , 'Forbidden');
        }
        if ($request->ajax()) {
            $data = CheckIn::with('user');
            return Datatables::of($data)
                ->filterColumn('employee_id' , function($query , $keyword){
                    $query->whereHas('user' , function ($q) use ($keyword){
                        $q->where('employee_id' , 'like' , '%' .$keyword . '%');
                    });
                })
                ->filterColumn('name' , function($query , $keyword){
                    $query->whereHas('user' , function ($q) use ($keyword){
                        $q->where('name' , 'like' , '%' .$keyword . '%');
                    });
                })
                ->addColumn('employee_id' , function ($each){
                    return $each->user ? $each->user->employee_id : '-';
                })
                ->addColumn('name' , function ($each){
                    return $each->user ? $each->user->name : '-';
                })
                ->make(true);
        }

        return view('attendance.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('view_attendance')){
            abort(403 , 'Forbidden');
        }
        return view('attendance.overview');
    }

    public function overviewTable(Request $request)
    {
        //
        if(!auth()->user()->can('view_attendance')){
            abort(403 , 'Forbidden');
        }
        $month =$request->month;
        $year =$request->year;
        $start_of_month = $year . '-' . $month  .'-'. '01';
        $end_of_month =Carbon::parse($start_of_month)->endOfMonth()->format('Y-m-d');

        $periods = new CarbonPeriod($start_of_month , $end_of_month);
        $employees =User::orderBy('employee_id')->where('employee_id' , 'like' , '%'.$request->employee_id.'%')->get();
        $attendaces = CheckIn::whereMonth('date' ,$month)->whereYear('date' ,$year)->get();
        $companySetting = Company::find(1);
        return view('components.table_overview' ,compact('periods' , 'employees' , 'attendaces' , 'companySetting'))->render();
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
