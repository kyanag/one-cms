<?php


namespace App\Supports;


use Illuminate\Http\Request;

/**
 * 服务于 webuploader
 * Class Uploader
 * @package App\Supports
 */
class Uploader
{

    /** @var string */
    const ATTR_VAL_FILE = "file";

    /** @var string */
    const ATTR_VAL_FILENAME = "name";

    /** @var int */
    const ATTR_VAL_CHUNK_COUNT = "chunks";

    /** @var int */
    const ATTR_VAL_CHUNK_INDEX = "chunk";

    private $saveDir;

    private $tempDir;

    private $subDirFormat = "Y-m-d";

    private $mimeTypes = [];

    public function __construct($config = [])
    {
        $this->saveDir = $config['saveDir'];
        $this->tempDir = $config['tempDir'];
        $this->subDirFormat = @$config['Y-m-d'] ?: "Y-m-d";

        if(isset($config['mimeTypes'])){
            $this->mimeTypes = $config['mimeTypes'];
        }
    }

    protected function saveDir($path){
        return $this->saveDir . DIRECTORY_SEPARATOR . $path;
    }

    protected function tempDir($path){
        return $this->tempDir . DIRECTORY_SEPARATOR . $path;
    }

    protected function savePathByFile($file){
        $md5 = md5_file($file);
        $filesize = filesize($file);

        $dir = $this->saveDir . DIRECTORY_SEPARATOR . date($this->subDirFormat, time());
        if(!file_exists($dir)){
            mkdir($dir, 755);
        }

        return $dir . DIRECTORY_SEPARATOR . "{$md5}_{$filesize}.{$this->getExtension($file)}";
    }

    /**
     * 获取扩展名不包含点号
     * @param $filename
     * @return mixed
     */
    protected function getExtension($filename){
        return pathinfo($filename,PATHINFO_EXTENSION);
    }

    public function upload(Request $request){
        $file = $request->file(static::ATTR_VAL_FILE);
        $filename = $request->input(static::ATTR_VAL_FILENAME);

        $chunkCount = intval($request->input(static::ATTR_VAL_CHUNK_COUNT, 1));
        $chunkIndex = intval($request->input(static::ATTR_VAL_CHUNK_INDEX, 0));

        $fileid = $request->input("id");

        if(!$this->saveChunk($file, $fileid, $chunkIndex)){
            throw new \Exception("文件上出错！");
        }
        if($chunkCount == $chunkIndex + 1){
            $chunkFiles = array_map(function($index) use($fileid){
                return $this->tempDir("{$fileid}.{$index}.part");
            }, range(0, $chunkIndex));
            $to = $this->saveDir("{$fileid}.{$this->getExtension($filename)}");
            return $this->mergeFiles($chunkFiles, $to);
        }else{
            return null;
        }
    }

    protected function saveChunk(\SplFileInfo $file, $fileid, $chunkIndex){
        $savePath = $this->tempDir("{$fileid}.{$chunkIndex}.part");

        return copy($file->getRealPath(), $savePath);
    }

    protected function mergeFiles($files, $to){
        if(file_exists($to)){
            throw new \Exception("文件已存在!");
        }
        $f = fopen($to, "w+");
        foreach ($files as $file){
            fwrite($f, file_get_contents($file));
            unlink($file);
        }
        fclose($f);

        $newfile = $this->savePathByFile($to);
        rename($to, $newfile);
        return $newfile;
    }
}