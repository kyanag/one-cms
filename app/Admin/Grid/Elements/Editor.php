<?php


namespace App\Admin\Grid\Elements;


use App\Supports\Asset;
use function Kyanag\Form\randomString;
use Kyanag\Form\Toolkits\Bootstrap3\Textarea;

class Editor extends Textarea
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
        <textarea id="form-{$this->id}" name="{$this->name}" style="min-height: 500px">{$this->value}</textarea>
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
    var ue = UE.getEditor('form-{$this->id}', {
        autoHeight: false
    });
})
EOF;
    }
}