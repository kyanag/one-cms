<?php


namespace App\Admin\Supports;


use App\Supports\Asset;
use Illuminate\Support\Traits\Macroable;
use Kyanag\Form\Component;
use Kyanag\Form\Components\Form;

/**
 * Class FormBuilder
 * @package App\Supports
 */
class FormBuilder
{
    use Macroable;

    public static function newForm(){
        $form = \createElement("form", [
            'id' => "OC-form-" . str_random(10),
        ]);
        return $form;
    }

    /**
     * @var Form
     */
    protected $form;

    public function __construct(Component $form = null)
    {
        if(is_null($form)){
            $form = static::newForm();
        }
        $this->form = $form;
    }

    /**
     * @param $method
     * @param bool $override
     */
    public function setMethod($method, $override = false){
        if(strtoupper($method) != "GET"){
            //post 表单要增加_token字段
            $hidden = createElement("hidden", [
                'name' => "_token",
            ]);
            $hidden->setValue(csrf_token());

            $this->form->addChild($hidden);

            //post 表单需要ajax上传
            Asset::registerJs(<<<EOF
$("#{$this->getId()}").ajaxForm({
    success: function(data,statusText){
        console.log(data, statusText);
    },
});
EOF
            );

        }
        $this->form->method = $method;
        $this->form->methodOverride = $override;
    }

    public function setAction($action){
        $this->form->action = $action;
    }

    public function setEnctype($enctype){
        $this->form->enctype = $enctype;
    }

    public function getId(){
        return $this->form->id;
    }

    public function setValue($attributes){
        $this->form->setValue($attributes);
    }


    public function built(){
        return $this->form;
    }
}