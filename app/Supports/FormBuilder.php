<?php


namespace App\Supports;


use Kyanag\Form\ActiveForm;
use Kyanag\Form\Interfaces\ComponentCollectionInterface;
use Kyanag\Form\Interfaces\ComponentInterface;
use Kyanag\Form\Toolkits\Bootstrap3\Checkbox;
use Kyanag\Form\Toolkits\Basic\Hidden;
use Kyanag\Form\Toolkits\Bootstrap3\Bootstrap3;
use Kyanag\Form\Toolkits\Bootstrap3\Fieldset;
use Kyanag\Form\Toolkits\Bootstrap3\Radio;
use Kyanag\Form\Toolkits\Bootstrap3\Select;
use Kyanag\Form\Toolkits\Bootstrap3\StaticLabel;
use Kyanag\Form\Toolkits\Bootstrap3\Text;
use Kyanag\Form\Toolkits\Bootstrap3\Textarea;
use Kyanag\Form\Traits\Macroable;

/**
 * Class FormBuilder
 * @package App\Supports
 */
class FormBuilder
{
    use Macroable;

    public static function newForm(){
        $theme = new Bootstrap3();
        $id = "OC-form-" . str_random(10);
        $theme->setAttribute("id", $id);

        return new ActiveForm($theme);
    }

    /**
     * @var ActiveForm
     */
    protected $form;

    public function __construct(ComponentCollectionInterface $form = null)
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
            $hidden = new Hidden('_token');
            $hidden->setValue(csrf_token());

            $this->form->getElement()->addElement($hidden);

            //post 表单需要ajax上传
            Asset::registerJs(<<<EOF
$("#{$this->getId()}").ajaxForm({
  success: function() {
    bootbox.alert("This is the default alert!");
  }
});
EOF
            );

        }
        $this->form->setMethod($method, $override);
    }

    public function setAction($action){
        $this->form->setAction($action);
    }

    public function setEnctype($enctype){
        $this->form->setEnctype($enctype);
    }

    public function getId(){
        return $this->form->getElement()->getAttribute("id");
    }


    public function text($name, $label = null){
        $text = new Text($name, $label);
        return $this->form->addComponent($text);
    }

    public function hidden($name){
        $hidden = new Hidden($name);
        return $this->form->addComponent($hidden);
    }

    public function display($name, $label = null){
        $staticLabel = new StaticLabel($name, $label);
        return $this->form->addComponent($staticLabel);
    }

    public function select($name, $label = null, $options = []){
        $select = new Select($name, $label, $options);
        return $this->form->addComponent($select);
    }

    /**
     * @param $name
     * @param null $label
     * @return ComponentInterface
     */
    public function textarea($name, $label = null){
        $textarea = new Textarea($name, $label);
        return $this->form->addComponent($textarea);
    }

    public function checkbox($name, $label = null, $options = []){
        $checkbox = new Checkbox($name, $label, $options);
        return $this->form->addComponent($checkbox);
    }

    public function switch($name, $label = null){
        $options = [
            0 => "关闭",
            1 => "打开"
        ];
        return $this->radio($name, $label, $options);
    }

    public function radio($name, $label = null, $options = []){
        $radio = new Radio($name, $label, $options);
        return $this->form->addComponent($radio);
    }


    public function hasOne($name, $label = null, $callable = null){
        $fieldset = new Fieldset($name, $label);
        if(is_callable($callable)){
            call_user_func_array($callable, [$fieldset]);
        }
        return $this->form->addComponent($fieldset);
    }

    public function setValue($attributes){
        $this->form->setValue($attributes);
    }


    public function built(){
        $this->form->getElement()->addElement(new \Kyanag\Form\Toolkits\Bootstrap3\Button());

        return $this->form;
    }
}