<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateEmployees;
use App\Http\Requests\EmployeesRequest;
use Yajra\DataTables\Facades\DataTables;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->can('create_employee')){
            abort(403 , 'Forbidden');
        }

        if ($request->ajax()) {
            $data = User::with('department');

            return Datatables::of($data)
                ->filterColumn('department_name' , function($query , $keyword){
                    $query->whereHas('department' , function ($q) use ($keyword){
                        $q->where('title' , 'like' , '%' .$keyword . '%');
                    });
                })
                ->addColumn('department_name' , function ($each){
                    return $each->department ? $each->department->title : '-';
                })
                ->addColumn('roles', function ($each) {
                    $output = '';
                    foreach ($each->roles as $role) {
                        $output .= '
                            <div class="px-1 py-1 mb-1 text-center bg-black text-white text-sm font-medium rounded-full">
                                '.$role->name.'
                            </div>';
                    };
                    return $output;
                })
                ->addColumn('Actions', function ($each) {
                    $edit_icon = '<a href="'. route('employees.edit' , $each->id ) .'" class="text-amber-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></a>';
                    $show_icon = '<a href="'. route('employees.show' , $each->id ) .'" class="text-green-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" /></svg></a>';
                    $delete_icon= '<a id="deleteItem" data-id="'.$each->id.'" class="text-red-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></a>';

                    return '<div class="flex justify-center">' . "$edit_icon" . "$show_icon" . "$delete_icon" . '</div>';
                })
                ->editColumn('is_present', function ($each) {
                    if ($each->is_present === 1) {
                        // Present Badge
                        return '<div class="flex justify-center items-center bg-green-500 text-white rounded-lg">
                                    Present
                                </div>';
                    } else {
                        // Not Present Badge
                        return '<div class="flex justify-center items-center bg-red-500 text-white rounded-lg">
                                    Not Present
                                </div>';
                    }
                })
                ->rawColumns(['is_present' ,'roles' ,'Actions'])
                ->make(true);
        }

        return view('employee.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('create_employee')){
            abort(403 , 'Forbidden');
        }
        $departments = Department::get();
        $roles = Role::all();
        return view('employee.create' , compact(['departments', 'roles']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\EmployeesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeesRequest $request)
    {
        // dd($request->all());
        if(!auth()->user()->can('create_employee')){
            abort(403 , 'Forbidden');
        }
        $validatedData = $request->validated();

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        $user->assignRole($request->roles);

        $temporaryFile = TemporaryFile::where('folder' , $request->filepond)->first();

        if($temporaryFile){
            $user->addMedia(storage_path('app/images/tmp/'.$request->filepond . '/' . $temporaryFile->filename))
            ->toMediaCollection('images');
            rmdir(storage_path('app/images/tmp/'.$request->filepond));
            $temporaryFile->delete();
        }

        return redirect()->route('employees.index')->with('created', 'Successfully Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $employee)
    {
        if(!auth()->user()->can('edit_employee')){
            abort(403 , 'Forbidden');
        }
        $departments = Department::get();

        return view('employee.show',  compact(['employee' ,'departments']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $employee)
    {
        //
        if(!auth()->user()->can('edit_employee')){
            abort(403 , 'Forbidden');
        }
        $departments = Department::get();

        $roles = Role::all();

        $old_roles = $employee->roles->pluck('id')->toArray();

        return view('employee.edit',  compact(['employee' ,'departments' ,'roles' , 'old_roles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateEmployees  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployees $request, $id)
    {
        if(!auth()->user()->can('edit_employee')){
            abort(403 , 'Forbidden');
        }
        $validatedData = $request->validated();

        $validatedData['password'] = Hash::make($request->password);

        $user = User::findOrFail($id);

        $user->update($validatedData);

        $user->syncRoles($request->roles);

        $temporaryFile = TemporaryFile::where('folder' , $request->filepond)->first();

        if($temporaryFile){
            $user->clearMediaCollection('images');

            $user->addMedia(storage_path('app/images/tmp/'.$request->filepond . '/' . $temporaryFile->filename))
            ->toMediaCollection('images');

            rmdir(storage_path('app/images/tmp/'.$request->filepond));

            $temporaryFile->delete();
        }

        return redirect()->route('employees.index')->with('updated', 'Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $employee)
    {
        if(!auth()->user()->can('remove_employee')){
            abort(403 , 'Forbidden');
        }
        $deleted = $employee->delete();

        if($deleted){
            $response['success'] = 1;
        }
        return response()->json($response);
    }
}
