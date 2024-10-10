<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use App\Models\ProjecLeader;
use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\TemporaryFile;
use App\Http\Requests\Updateproject;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProjectRequest;
use Yajra\DataTables\Facades\DataTables;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->can('create_project')){
            abort(403 , 'Forbidden');
        }
        if ($request->ajax()) {
            $data = Project::query();

            return Datatables::of($data)
                ->editColumn('priority', function ($each) {
                    if($each->priority == 'high') {
                        return '<div class="badge badge-success bg-green-600">' . $each->priority . '</div>';
                    } elseif ($each->priority == 'middle') {
                        return '<div class="badge badge-warning bg-orange-400">' . $each->priority . '</div>';
                    } else {
                        return '<div class="badge badge-error bg-red-600">' . $each->priority . '</div>';
                    }
                })
                ->editColumn('status', function ($each) {
                    if($each->status == 'progess') {
                        return '<div class="badge badge-success bg-blue-600">' . $each->status . '</div>';
                    } elseif ($each->status == 'pending') {
                        return '<div class="badge badge-warning bg-orange-400">' . $each->status . '</div>';
                    } else {
                        return '<div class="badge badge-error bg-green-600">' . $each->status . '</div>';
                    }
                })
                ->editColumn('description', function ($each) {
                    return  Str::of($each->description)->limit(30);
                })
                ->addColumn('Actions', function ($each) {
                    $edit_icon = '<a href="'. route('project.edit' , $each->id ) .'" class="text-amber-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg></a>';
                    $show_icon = '<a href="'. route('project.show' , $each->id ) .'" class="text-green-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" /></svg></a>';
                    $delete_icon= '<a id="deleteItem" data-id="'.$each->id.'" class="text-red-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></a>';

                    return '<div class="flex justify-center">' . "$edit_icon" . "$show_icon" . "$delete_icon" . '</div>';
                })
                ->rawColumns(['Actions' , 'priority', 'status'])
                ->make(true);
        }

        return view('projects.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('create_project')){
            abort(403 , 'Forbidden');
        }
        $employees = User::all();
        return view('projects.create' ,compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\projectsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        // dd($request->all());
        if(!auth()->user()->can('create_project')){
            abort(403 , 'Forbidden');
        }
        $validatedData = $request->validated();

        $project = Project::create($validatedData);

        if($request->has('leaders')){
            foreach ($request->leaders ?? [] as $leader) {
                ProjecLeader::firstOrCreate([
                    'user_id' => $leader,
                    'project_id' => $project->id,
                ]);
            }
        }

        if($request->has('members')){
            foreach ($request->members ?? [] as $members) {
                ProjectMember::firstOrCreate([
                    'user_id' => $members,
                    'project_id' => $project->id,
                ]);
            }
        }

        if($request->images){
            $files = $request->images;
            // dd($files);
                foreach ($files as $file) {
                        $decodedFile = json_decode($file, true);
                        $folderName = $decodedFile[0];
                        $temporaryFile = TemporaryFile::where('folder' ,  $folderName)->first();
                        if($temporaryFile){
                            $project->addMedia(storage_path('app/images/tmp/'. $folderName . '/' . $temporaryFile->filename))
                            ->toMediaCollection('images');
                            rmdir(storage_path('app/images/tmp/'. $folderName));
                            $temporaryFile->delete();
                        }
                }
        }

        if($request->has('files')){
            $files = $request->input('files');

                foreach ($files as $file) {
                        $decodedFile = json_decode($file, true);
                        $folderName = $decodedFile[0];
                        $temporaryFile2 = TemporaryFile::where('folder' , $folderName)->first();

                        if($temporaryFile2){
                            $project->addMedia(storage_path('app/files/tmp/'.$folderName . '/' . $temporaryFile2->filename))
                            ->toMediaCollection('files');
                            rmdir(storage_path('app/files/tmp/'.$folderName));
                            $temporaryFile2->delete();
                        }
                }
        }
        return redirect()->route('project.index')->with('created', 'Successfully Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if(!auth()->user()->can('create_project')){
            abort(403 , 'Forbidden');
        }

        $leaders = $project->leaders;

        $leaderImages = [];
        foreach ($leaders as $leader) {
            $images = $leader->getMedia('images');
            $leaderImages[] = $images;
        }

        $members = $project->members;
        $memberImages = [];
        foreach ($members as $member) {
            $images = $member->getMedia('images');
            $memberImages[] = $images;
        }
        return view('projects.show',  compact(['project' , 'leaderImages' , 'memberImages']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
        if(!auth()->user()->can('create_project')){
            abort(403 , 'Forbidden');
        }
        $employees = User::all();
        $oldLeaders = $project->leaders->pluck('id')->toArray();
        $oldMembers = $project->members->pluck('id')->toArray();

        return view('projects.edit',  compact(['project' ,'employees' , 'oldLeaders' ,'oldMembers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Updateproject  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Updateproject $request, $id)
    {
        if(!auth()->user()->can('create_project')){
            abort(403 , 'Forbidden');
        }
        $validatedData = $request->validated();

        $project = Project::findOrFail($id);

        $project->update($validatedData);

        if($request->has('leaders')){
            $project->leaders()->sync($request->leaders);
        }

        if($request->has('members')){
            $project->members()->sync($request->members);
        }

        if($request->images){
            $files = $request->images;
            // dd($files);
                foreach ($files as $file) {
                        $decodedFile = json_decode($file, true);
                        $folderName = $decodedFile[0];

                        $temporaryFile = TemporaryFile::where('folder' ,  $folderName)->first();

                        if($temporaryFile){
                            $project->clearMediaCollection('images');

                            $project->addMedia(storage_path('app/images/tmp/'. $folderName . '/' . $temporaryFile->filename))
                            ->toMediaCollection('images');
                            rmdir(storage_path('app/images/tmp/'. $folderName));
                            $temporaryFile->delete();
                        }
                }
        }

        if($request->has('files')){
            $files = $request->input('files');

                foreach ($files as $file) {
                        $decodedFile = json_decode($file, true);
                        $folderName = $decodedFile[0];
                        $temporaryFile2 = TemporaryFile::where('folder' , $folderName)->first();

                        if($temporaryFile2){
                            $project->clearMediaCollection('files');

                            $project->addMedia(storage_path('app/files/tmp/'. $folderName . '/' . $temporaryFile2->filename))
                            ->toMediaCollection('files');
                            rmdir(storage_path('app/files/tmp/'. $folderName));
                            $temporaryFile2->delete();
                        }
                }
        }

        return redirect()->route('project.index')->with('updated', 'Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if(!auth()->user()->can('create_project')){
            abort(403 , 'Forbidden');
        }
        $project->leaders()->detach();
        $project->members()->detach();

        $deleted = $project->delete();

        if($deleted){
            $response['success'] = 1;
        }
        return response()->json($response);
    }
}
