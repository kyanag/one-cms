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


    public function __construct()
    {
        $this->content = function($model, $key, $index){
            $id = data_get($model, $key);
            $view = $this->urlCreator->show([
                $id
            ]);
            $update = $this->urlCreator->edit([
                $id
            ]);
            $delete = $this->urlCreator->destroy([
                $id
            ]);

            return strtr($this->template, [
                "{view}" => "<a class=\"btn btn-outline-primary btn-sm\" href=\"{$view}\">查看</a>",
                "{update}" => "<a class=\"btn btn-primary btn-sm\" href=\"{$update}\">编辑</a>",
                "{delete}" => "<a 
class=\"btn btn-warning btn-sm J_confirm_modal\" 
href=\"{$delete}\" 
data-tip=\"确认删除?\"
data-type=\"delete\"
>删除</a>"
            ]);
        };
    }
}