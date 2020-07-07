<?php

namespace App\Http\Controllers;


use App\Supports\HeadMatting;
use App\Supports\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //

    public function worktable(){
        return view("image.worktable");
    }


    public function store(Request $request){
        $saveDir = public_path("uploads");
        $uploader = new Uploader([
            'saveDir' => $saveDir,
            'tempDir' => storage_path("temp")
        ]);
        $file = $uploader->upload($request);

        $url = str_replace($saveDir, "", $file);
        return $url;
    }

    public function headmatting(Request $request){
        $file = $request->file(Uploader::ATTR_VAL_FILE);
        $scan_type = $request->input("scan_type", "foreground");

        $blob = HeadMatting::fromFile($file->getRealPath(), [
            $scan_type
        ])->scan()->toBlob();
        return response()->stream(function() use($blob){
            $out = fopen('php://output', 'wb');

            fwrite($out, $blob);
            fclose($out);
        }, 200, [
            'Content-Type' => "image/*"
        ]);
    }

}
