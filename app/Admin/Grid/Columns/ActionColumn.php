<?php


namespace App\Admin\Grid\Columns;


use App\Supports\UrlCreator;


/**
 * Class ActionColumn
 * @package App\Admin\Grid\Columns
 */
class ActionColumn extends DataColumn
{

    public $template = "{view} {update} {delete}";

    /**
     * @var UrlCreator
     */
    public $urlCreator;


    public function boot()
    {
        $this->content = function($model, $key, $index){
            $view = $this->urlCreator->show([
                $model[$key]
            ]);
            $update = $this->urlCreator->edit([
                $model[$key]
            ]);
            $delete = $this->urlCreator->destroy([
                $model[$key]
            ]);

            return strtr($this->template, [
                "{view}" => "<a class=\"btn btn-default btn-xs\" href=\"{$view}\">查看</a>",
                "{update}" => "<a class=\"btn btn-primary btn-xs\" href=\"{$update}\">编辑</a>",
                "{delete}" => "<a 
class=\"btn btn-warning btn-xs J_confirm_modal\" 
href=\"{$delete}\" 
data-tip=\"确认删除?\"
data-type=\"delete\"
>删除</a>"
            ]);
        };
        parent::boot();
    }
}