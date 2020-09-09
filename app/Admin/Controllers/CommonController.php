<?php


namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Supports\Uploader;
use Illuminate\Http\Request;

class CommonController extends Controller
{


    public function upload(Request $request){
        $saveDir = public_path("uploads");
        $uploader = new Uploader([
            'saveDir' => $saveDir,
            'tempDir' => storage_path("temp")
        ]);
        $file = $uploader->upload($request);
        if($file === null){
            return response()->json([
                'msg' => "part success!",
            ]);
        }
        $url = str_replace($saveDir, "", $file);
        return response()->json([
            'msg' => "上传成功!",
            'url' => $url,
        ]);
    }

}