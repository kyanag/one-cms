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