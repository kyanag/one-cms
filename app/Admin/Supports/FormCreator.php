<?php


namespace App\Admin\Supports;


use App\Admin\Annotations\RelationAttribute;
use App\Admin\Facades\Admin;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;
use Kyanag\Form\Component;
use Kyanag\Form\Components\Form;
use Kyanag\Form\Components\Forms\HasOne;
use Kyanag\Form\Components\FormSection;
use Kyanag\Form\Components\Tabs;
use Kyanag\Form\Renderable;

class FormCreator
{

    /**
     * 主模型描述
     * @var InspectorInterface
     */
    protected $inspector;

    /**
     * 附加关系
     * @var array<RelationInspectorInterface>
     */
    protected $activeRelatedNames = [];

    /**
     * 附加表单
     * @var array<\App\Models\Form>
     */
    protected $forms = [];


    public function __construct(InspectorInterface $inspector, $activeRelatedNames = [], $forms = [])
    {
        $this->inspector = $inspector;
        $this->activeRelatedNames = $activeRelatedNames;
        $this->forms = $forms;
    }

    public function withRelated($names = []){
        $this->activeRelatedNames = $names;
    }


    public function withForms($forms = []){
        $this->forms = $forms;
    }

    public function addForm($form){
        $this->forms[] = $form;
    }


    public function toForm($scene){
        /** @var Tabs $tab */
        $tab = Admin::createElement("tabs", []);

        $tab->addTab("主内容", $this->toMainFormSection($scene));

        /** @var \App\Models\Form $form */
        foreach ($this->forms as $form){
            $tab->addTab($form->title, $form->toFormSection());
        }
        return $tab;
    }


    protected function toMainFormSection($scene){
        /** @var FormSection $formSection */
        $formSection = Admin::createElement("form-section", [
            'value' => [],
        ]);

        $children = $this->getChildren($scene);
        foreach ($children as $child){
            $formSection->addChild($child);
        }
        return $formSection;
    }

    /**
     * @param $scene
     * @return array<Renderable|Component>
     */
    protected function getChildren($scene){
        $children = [];

        /** @var FieldInspectorInterface $field */
        foreach ($this->inspector->getFields() as $field){
            if($field->ableFor($scene)){
                $children[] = $field->toElement();
            }
        }

        foreach ($this->activeRelatedNames as $activeRelation){
            $relationInspector = $this->inspector->getRelation($activeRelation);
            $foreignInspector = $relationInspector->getForeignInspector();

            $onSceneFields = array_filter($foreignInspector->getFields(), function($field) use($scene){
                return $field->ableFor($scene);
            });

            switch ($relationInspector->getRelationshipType()){
                case RelationAttribute::RELATION_HAS_MANY:
                    $ele_type = "has-many";
                    break;
                case RelationAttribute::RELATION_HAS_ONE:
                case RelationAttribute::RELATION_BELONG_TO:
                default:
                    $ele_type = "has-one";
                    break;
            }

            //构造has-one/has-many 表单
            $children[] = Admin::createElement($ele_type, [
                'name' => $activeRelation,
                'label' => $foreignInspector->getTitle(),
                'value' => [],
                'children' => \Kyanag\Form\array_map($onSceneFields, function($field, $index){
                    return $field->toElement();
                })
            ]);
        }
        return $children;
    }


    public function toFormSection($scene){
        /** @var FormSection $formSection */
        $formSection = Admin::createElement("form-section", [
            'value' => [],
        ]);

        $children = $this->getChildren($scene);
        foreach ($children as $child){
            $formSection->addChild($child);
        }
        return $formSection;
    }
}