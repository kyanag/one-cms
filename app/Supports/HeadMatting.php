<?php


namespace App\Supports;


use AipBodyAnalysis;

class HeadMatting
{
    /**
     * 处理过后的body
     * @var array
     */
    protected $outBody = [];

    protected $activeType = "foreground";

    /**
     * 处理前的图片body
     * @var string
     */
    protected $inBody;

    /**
     * @var bool
     */
    protected $scanned = false;


    protected $options = [];


    public static function fromString($body, array $type = []){
        $static = new static();
        $static->inBody = $body;
        $static->options = [
            'type' => $type
        ];
        return $static;
    }

    public static function fromFile($file, array $type = []){
        $body = file_get_contents($file);
        return static::fromString($body, $type);
    }


    public function scan(){
        if($this->scanned === false){
            $client = new AipBodyAnalysis(
                config("_cloud.baidu.image.appId"),
                config("_cloud.baidu.image.appKey"),
                config("_cloud.baidu.image.appSecret")
            );

            // 如果有可选参数
            $options = $this->options;
            if(isset($options['type'])){
                if(count($options['type']) == 1){
                    $this->activeType = $options['type'][0];
                }
                $options['type'] = implode(",", $options['type']);
            }

            // 带参数调用人像分割
            $res = $client->bodySeg($this->inBody, $options);

            $outBody = [];
            foreach ($this->options['type'] as $option){
                $outBody[$option] = base64_decode($res[$option]);
            }
            $this->outBody = $outBody;
            $this->scanned = true;
        }

        return $this;
    }


    public function foreground(){
        if($this->scanned === false){
            $this->options['type'] = [
                "foreground"
            ];
            $this->scan();
        }
        $this->activeType = "foreground";
        return $this;
    }

    public function scoremap(){
        if($this->scanned === false){
            $this->options['type'] = [
                "scoremap"
            ];
            $this->scan();
        }
        $this->activeType = "scoremap";
        //var_dump($this->outBody[$this->activeType]);exit();
        return $this;
    }

    public function toBlob(){
        return $this->outBody[$this->activeType];
    }

    public function saveAs($path){
        if($this->scanned === false){
            $this->foreground();
        }
        return file_put_contents($path, $this->outBody[$this->activeType]);
    }

}