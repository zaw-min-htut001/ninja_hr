<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CheckIn;
use App\Models\Company;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!auth()->user()->can('view_payroll')){
            abort(403 , 'Forbidden');
        }
        return view('payroll.overview');
    }


    public function payrolloverviewTable(Request $request)
    {

        if(!auth()->user()->can('view_payroll')){
            abort(403 , 'Forbidden');
        }
        $month =$request->month;
        $year =$request->year;
        $start_of_month = $year . '-' . $month  . '-01';
        $end_of_month =Carbon::parse($start_of_month)->endOfMonth()->format('Y-m-d');

        $dayInMonth = Carbon::parse($start_of_month)->daysInMonth;

        $workingDaysMonth = Carbon::parse($start_of_month)->diffInDaysFiltered(function (Carbon $date){
            return $date->isweekDay();
        } , $end_of_month) + 1;

        // $offDays = $dayInMonth - $workingDays;

        $periods = new CarbonPeriod($start_of_month , $end_of_month);

        $employees =User::orderBy('employee_id')->where('employee_id' , 'like' , '%'.$request->employee_id.'%')->get();
        $attendaces = CheckIn::whereMonth('date' ,$month)->whereYear('date' ,$year)->get();
        $companySetting = Company::find(1);
        return view('components.payroll-overview' ,compact('workingDaysMonth','month', 'year' ,'dayInMonth',  'periods' ,'employees' , 'attendaces' , 'companySetting'))->render();
    }

    public function myOverviewTable(Request $request)
    {
        if(!auth()->user()->can('view_my_attendance_history')){
            abort(403 , 'Forbidden');
        }
        $month =$request->month;
        $year =$request->year;
        $start_of_month = $year . '-' . $month  . '-01';
        $end_of_month =Carbon::parse($start_of_month)->endOfMonth()->format('Y-m-d');

        $dayInMonth = Carbon::parse($start_of_month)->daysInMonth;

        $workingDaysMonth = Carbon::parse($start_of_month)->diffInDaysFiltered(function (Carbon $date){
            return $date->isweekDay();
        } , $end_of_month) + 1;

        // $offDays = $dayInMonth - $workingDays;

        $periods = new CarbonPeriod($start_of_month , $end_of_month);

        $employees =User::orderBy('employee_id')->where('id' , Auth::user()->id )->get();
        $attendaces = CheckIn::whereMonth('date' ,$month)->whereYear('date' ,$year)->get();
        $companySetting = Company::find(1);
        return view('components.payroll-overview' ,compact('workingDaysMonth','month', 'year' ,'dayInMonth',  'periods' ,'employees' , 'attendaces' , 'companySetting'))->render();
    }
}
