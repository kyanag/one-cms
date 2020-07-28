<?php

namespace App\Admin\Controllers;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\InspectorAdapter;
use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;
use App\Components\GridView;
use App\Models\Category;
use App\Models\Post;
use App\Supports\FormBuilder;
use Illuminate\Support\Facades\Input;

class PostController extends _InspectorController
{

    /** @var Category */
    private $category;

    protected function createInspector()
    {
        /** @var InspectorAdapter $inspector */
        $inspector = app(\App\Admin\Grid\InspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Post())
            ->built();

        $category = Category::query()
            ->where("id", app("request")
            ->input("category_id"))
            ->first();
        if(is_null($category)){
            throw new \Exception("不存在的栏目分类");
        }
        $this->category = $category;
        return $inspector;
    }

    public function createUrlCreator()
    {
        $urlCreator = parent::createUrlCreator();
        $urlCreator->setDefaultQuery([
            'category_id' => Input::get("category_id")
        ]);
        return $urlCreator;
    }

    protected function newModel()
    {
        return new Post();
    }

    protected function newQuery()
    {
        return $this->newModel()
            ->newQuery()
            ->with($this->category['type']);
    }


    protected function getGrid()
    {
        $attributeInspectors = $this->inspector->getAttributes();

        $attributeInspectors = array_filter($attributeInspectors, function(AttributeInspectorInterface $fieldInspector){
            return $fieldInspector->ableFor(FieldAttribute::ABLE_SHOW);
        });

        //处理附表
        /** @var RelationInspectorInterface $relationInspector */
        $relationInspector = $this->inspector->getRelations()[$this->category['type']];
        /** @var InspectorInterface $foreignInspector */
        $foreignInspector = $relationInspector->getForeignInspector();
        $foreignAttributeInspectors = array_filter($foreignInspector->getAttributes(), function(AttributeInspectorInterface $fieldInspector){
            return $fieldInspector->ableFor(FieldAttribute::ABLE_SHOW);
        });
        $attributeInspectors = array_merge($attributeInspectors, $foreignAttributeInspectors);

        $gridView = GridView::create([
            'caption' => "{$this->inspector->getTitle()} 列表",
            'columns' => array_map(function(AttributeInspectorInterface $fieldInspector){
                return $fieldInspector->toColumn();
            }, $attributeInspectors),
        ]);
        return $gridView;
    }


    public function getForm($scene)
    {
        $form = FormBuilder::newForm();

        /** @var AttributeInspectorInterface $attribute */
        foreach ($this->inspector->getAttributes() as $attribute){
            if($attribute->ableFor($scene)){
                $form->addComponent($attribute->toElement());
            }
        }

        //处理附表
        /** @var RelationInspectorInterface $relationInspector */
        $relationInspector = $this->inspector->getRelations()[$this->category['type']];
        /** @var InspectorInterface $foreignInspector */
        $foreignInspector = $relationInspector->getForeignInspector();
        foreach ($foreignInspector->getAttributes() as $attribute){
            if($attribute->ableFor($scene)){
                $form->addComponent($attribute->toElement());
            }
        }

        return $form;
    }
}
