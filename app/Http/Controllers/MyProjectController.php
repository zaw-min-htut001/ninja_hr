<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use App\Models\ProjecLeader;
use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\TemporaryFile;
use App\Http\Requests\Updateproject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProjectRequest;
use Yajra\DataTables\Facades\DataTables;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MyProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->can('view_project')){
            abort(403 , 'Forbidden');
        }
        if ($request->ajax()) {
            $data = Project::with('leaders' , 'members')->whereHas('leaders' , function($query){
                $query->where('user_id' , Auth::user()->id);
            })
            ->orWhereHas('members' , function($query){
                $query->where('user_id' , Auth::user()->id);
            })->get();

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
                    $show_icon = '<a href="'. route('my-project.show' , $each->id ) .'" class="text-green-500 bg-amber-100 p-1 rounded-lg me-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" /></svg></a>';

                    return '<div class="flex justify-center">' . "$show_icon" . '</div>';
                })
                ->rawColumns(['Actions' , 'priority', 'status'])
                ->make(true);
        }

        return view('my-projects.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!auth()->user()->can('view_project')){
            abort(403 , 'Forbidden');
        }
        $project = Project::with('leaders' , 'members' , 'tasks.members')
            ->whereHas('leaders' , function($query){
                $query->where('user_id' , Auth::user()->id);
            })
            ->orWhereHas('members' , function($query){
                $query->where('user_id' , Auth::user()->id);
            })
        ->findOrFail($id);

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
        return view('my-projects.show',  compact(['project' , 'leaderImages' , 'memberImages' ]));
    }

}
