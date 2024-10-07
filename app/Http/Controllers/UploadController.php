<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    //
    public function store(Request $request)
    {
        if(!auth()->user()->can('create_employee')){
            abort(403 , 'Forbidden');
        }
        if($request->hasFile('filepond')){
            $file = $request->file('filepond');
            $fileName = $file->getClientOriginalName();
            $folder = uniqid().'-'. now()->timestamp;
            $file->storeAs('/images/tmp/'.$folder , $fileName);

            TemporaryFile::create([
                'filename' => $fileName,
                'folder' => $folder,
            ]);
            return $folder;
        }
        return '';
    }
    //
    public function destory(Request $request)
    {
        if(!auth()->user()->can('create_employee')){
            abort(403 , 'Forbidden');
        }
        $id = $request->getContent();
        $temporaryFile = TemporaryFile::where('folder' , $id)->first();
        $directory = storage_path('app/images/tmp/'.$id);

            // Remove the directory and its contents
            if (File::exists($directory)) {
                File::deleteDirectory($directory);
                $temporaryFile->delete();
            }
    }

    public function storeMulti(Request $request)
    {
        $folders = [];
        if($request->hasFile('images')){
            $files = $request->file('images');
               foreach ($files as $file) {
                        $filename = $file->getClientOriginalName();
                        $folder = uniqid() . '-' . now()->timestamp;
                        $file->storeAs('/images/tmp/' . $folder, $filename);

                        TemporaryFile::create([
                            'filename' => $filename,
                            'folder' => $folder,
                        ]);
                        $folders[] = $folder;
                }
                return response()->json($folders);
        }
        return '';
    }

    public function storeFiles(Request $request)
    {
        $folders = [];

        if($request->hasFile('files')){
            $files = $request->file('files');
               foreach ($files as $file) {
                        $filename = $file->getClientOriginalName();
                        $folder = uniqid() . '-' . now()->timestamp;
                        $file->storeAs('/files/tmp/' . $folder, $filename);

                        TemporaryFile::create([
                            'filename' => $filename,
                            'folder' => $folder,
                        ]);
                        $folders[] = $folder;
                }
                return response()->json($folders);
        }
        return '';
    }

    public function destoryImages(Request $request)
    {
        if(!auth()->user()->can('create_project')){
            abort(403 , 'Forbidden');
        }
        $id = $request->getContent();
        $decodedFile = json_decode($id, true);
        $folderName = $decodedFile[0];

        $temporaryFile = TemporaryFile::where('folder' , $folderName)->first();
        $directory = storage_path('app/images/tmp/'.$folderName);

            // Remove the directory and its contents
            if (File::exists($directory)) {
                File::deleteDirectory($directory);
                $temporaryFile->delete();
            }
    }

    public function destoryFiles(Request $request)
    {
        if(!auth()->user()->can('create_project')){
            abort(403 , 'Forbidden');
        }
        $id = $request->getContent();
        $decodedFile = json_decode($id, true);
        $folderName = $decodedFile[0];

        $temporaryFile = TemporaryFile::where('folder' , $folderName)->first();
        $directory = storage_path('app/files/tmp/'.$folderName);

            // Remove the directory and its contents
            if (File::exists($directory)) {
                File::deleteDirectory($directory);
                $temporaryFile->delete();
            }
    }
}
