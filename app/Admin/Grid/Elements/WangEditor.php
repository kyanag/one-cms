<?php


namespace App\Admin\Grid\Elements;


use App\Supports\Asset;
use function Kyanag\Form\randomString;
use Kyanag\Form\Toolkits\Bootstrap3\Textarea;

class WangEditor extends Textarea
{

    protected $id;


    public function __construct($name, $label = null)
    {
        parent::__construct($name, $label);
        $this->id = randomString($this->name);
    }

    public function render()
    {

        $hasError = $this->error ? "has-error" : "";
        $helpText = $this->error ?: $this->help;

        $tpl = <<<TPL
<div class="form-group {$hasError}">
    <label for="form-{$this->id}" class="col-sm-2 control-label">{$this->label}</label>
    <div class="col-sm-8">
        <div id="form-{$this->id}-editor" >{$this->value}</div>
        <textarea id="form-{$this->id}-input" name="{$this->name}" style="display: none;">{$this->value}</textarea>
    </div>
    <p class="col-sm-2 help-block">{$helpText}</p>
 </div>
TPL;
        Asset::registerJs($this->renderJs());
        return $tpl;
    }

    public function renderJs(){
        return <<<EOF
$(function(){
    var E = window.wangEditor
    var editor = new E('#form-{$this->id}-editor')
    editor.customConfig.onchange = function (html) {
        // 监控变化，同步更新到 textarea
        console.log(html);
        $("#form-{$this->id}-input").val(html)
    }
    editor.create();
    console.log(editor);
})
EOF;
    }
}