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
        $id = $request->getContent();
        $temporaryFile = TemporaryFile::where('folder' , $id)->first();
        $directory = storage_path('app/images/tmp/'.$id);

            // Remove the directory and its contents
            if (File::exists($directory)) {
                File::deleteDirectory($directory);
                $temporaryFile->delete();
            }
    }
}
