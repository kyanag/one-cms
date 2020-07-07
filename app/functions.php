<?php


function flash($message, $level = "info"){
    session()->flash($level, $message);
}

/**
 * 判断是否来自iframe的访问
 * @return bool
 */
function is_iframe(){
    return app("request")->has("is_frame");
}