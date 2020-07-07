<?php


namespace App\Supports;


class Asset
{

    const BODY_END = 0;
    const BODY_START = 1;

    static $js = [];

    public static function registerJs($js, $position = 1){
        static::$js[] = $js;
    }

}