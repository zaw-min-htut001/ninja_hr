<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Salary;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateSalary;
use App\Http\Requests\SalaryRequest;
use Yajra\DataTables\Facades\DataTables;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->can('create_salary')){
            abort(403 , 'Forbidden');
        }
        if ($request->ajax()) {
            $data = Salary::with('user');

            return Datatables::of($data)
                ->filterColumn('employee_id' , function($query , $keyword){
                    $query->whereHas('user' , function ($q) use ($keyword){
                        $q->where('employee_id' , 'like' , '%' .$keyword . '%');
                    });
                })
                ->addColumn('employee_id' , function ($each){
                    return $each->user ? $each->user->employee_id : '-';
                })
                ->editColumn('month' , function ($each){
                    return Carbon::parse('2024-' . $each->month . '-01')->format('M');
                })
                ->editColumn('amount' , function ($each){
                    return number_format($each->amount);
                })
                ->addColumn('Actions', function ($each) {
                    $edit_icon = '<a href="'. route('salary.edit' , $each->id ) .'" class="text-amber-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></a>';
                    $delete_icon= '<a id="deleteItem" data-id="'.$each->id.'" class="text-red-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></a>';

                    return '<div class="flex justify-center">' . "$edit_icon" . "$delete_icon" . '</div>';
                })
                ->rawColumns(['Actions'])
                ->make(true);
        }

        return view('salary.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(!auth()->user()->can('create_salary')){
            abort(403 , 'Forbidden');
        }
        $employees =User::all();
        return view('salary.create' , compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SalaryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryRequest $request)
    {
        if(!auth()->user()->can('create_salary')){
            abort(403 , 'Forbidden');
        }
        $validatedData = $request->validated();

        $Salary = Salary::create($validatedData);

        return redirect()->route('salary.index')->with('created', 'Successfully Created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        //
        if(!auth()->user()->can('edit_salary')){
            abort(403 , 'Forbidden');
        }
        $employees =User::all();

        return view('salary.edit',  compact(['salary' , 'employees']));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateSalary  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalary $request, $id)
    {
        if(!auth()->user()->can('edit_salary')){
            abort(403 , 'Forbidden');
        }
        $validatedData = $request->validated();

        $salary = Salary::findOrFail($id);

        $salary->update($validatedData);

        return redirect()->route('salary.index')->with('updated', 'Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        if(!auth()->user()->can('remove_salary')){
            abort(403 , 'Forbidden');
        }
        $deleted = $salary->delete();

        if($deleted){
            $response['success'] = 1;
        }
        return response()->json($response);
    }
}
