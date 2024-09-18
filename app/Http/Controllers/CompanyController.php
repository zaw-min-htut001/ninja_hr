<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCompany;
use App\Http\Requests\UpdateCompanySetting;

class CompanyController extends Controller
{

    public function index()
    {
        if(!auth()->user()->can('view_company')){
            abort(403 , 'Forbidden');
        }
        $company = Company::find(1);

        return view('company-setting.show',  compact(['company']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        if(!auth()->user()->can('edit_company')){
            abort(403 , 'Forbidden');
        }
        $company = Company::find(1);

        return view('company-setting.edit',  compact(['company']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\UpdateCompanySetting  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanySetting $request, $id)
    {
        if(!auth()->user()->can('edit_company')){
            abort(403 , 'Forbidden');
        }
        $validatedData = $request->validated();

        $company = Company::findOrFail($id);

        $company->update($validatedData);

        return redirect()->route('company-setting.index')->with('updated', 'Successfully Updated!');
    }

}
