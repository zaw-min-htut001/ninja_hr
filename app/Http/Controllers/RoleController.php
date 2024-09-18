<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateRole;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->can('create_role')){
            abort(403 , 'Forbidden');
        }
        if ($request->ajax()) {
            $data = Role::query();

            return Datatables::of($data)
                ->addColumn('permissions', function ($each) {
                    $output = '';
                    foreach ($each->permissions as $permission) {
                        $output .= '
                            <span class="px-1 py-1 text-center bg-black text-white text-sm font-medium rounded-full">
                                '.$permission->name.'
                            </span>';
                    };
                    return '<div class="grid grid-cols-3 gap-1">' . $output . ' </div>';
                })
                ->addColumn('Actions', function ($each) {
                    $edit_icon = '<a href="'. route('roles.edit' , $each->id ) .'" class="text-amber-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></a>';
                    $delete_icon= '<a id="deleteItem" data-id="'.$each->id.'" class="text-red-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></a>';

                    return '<div class="flex justify-center">' . "$edit_icon" . "$delete_icon" . '</div>';
                })
                ->rawColumns(['permissions','Actions'])
                ->make(true);
        }

        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(!auth()->user()->can('create_role')){
            abort(403 , 'Forbidden');
        }
        $permissions = Permission::all();
        return view('role.create' , compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        if(!auth()->user()->can('create_role')){
            abort(403 , 'Forbidden');
        }
        $validatedData = $request->validated();

        $role = Role::create($validatedData);

        $role->givePermissionTo($request->permissions);

        return redirect()->route('roles.index')->with('created', 'Successfully Created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if(!auth()->user()->can('edit_role')){
            abort(403 , 'Forbidden');
        }
        $permissions = Permission::all();

        $old_permissions = $role->permissions->pluck('id')->toArray();

        return view('role.edit',  compact(['role' , 'permissions' , 'old_permissions' ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\UpdateRole  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRole $request, $id)
    {
        if(!auth()->user()->can('edit_role')){
            abort(403 , 'Forbidden');
        }
        $validatedData = $request->validated();

        $role = Role::findOrFail($id);

        $role->update($validatedData);

        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('updated', 'Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if(!auth()->user()->can('remove_role')){
            abort(403 , 'Forbidden');
        }
        $deleted = $role->delete();

        if($deleted){
            $response['success'] = 1;
        }
        return response()->json($response);
    }
}
