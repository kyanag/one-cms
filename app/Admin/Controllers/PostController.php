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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

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


    /**
     * Store a newly created resource in storage.
     * @param  Request  $request
     * @return Response
     * @throws HttpException
     */
    public function store(Request $request)
    {

        $attributes = $this->validate(
            $request,
            $this->getRules(FieldAttribute::ABLE_CREATE),
            [],
            $this->getLabels()
        );

        $model = $this->newModel();
        $model->fill($attributes);

        if($model->saveOrFail()){
            return \response()->json([
                'msg' => "保存成功!",
                'jump' => $this->urlCreator->index(),
            ]);
        }else{
            throw new ServiceUnavailableHttpException();
        }
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
        $attributeInspectors = $this->getAttributes();

        $attributeInspectors = array_filter($attributeInspectors, function(AttributeInspectorInterface $fieldInspector){
            return $fieldInspector->ableFor(FieldAttribute::ABLE_SHOW);
        });

        $gridView = GridView::create([
            'caption' => "{$this->inspector->getTitle()} 列表",
            'columns' => array_map(function(AttributeInspectorInterface $fieldInspector){
                return $fieldInspector->toColumn();
            }, $attributeInspectors),
        ]);
        return $gridView;
    }

    protected function getAttributes(){
        $attributeInspectors = $this->inspector->getAttributes();
        //处理附表
        /** @var RelationInspectorInterface $relationInspector */
        $relationInspector = $this->inspector->getRelations()[$this->category['type']];
        /** @var InspectorInterface $foreignInspector */
        $foreignAttributeInspectors = $relationInspector->getForeignInspector()->getAttributes();

        return array_merge($attributeInspectors, $foreignAttributeInspectors);
    }

    public function getForm($scene)
    {
        $form = FormBuilder::newForm();

        /** @var AttributeInspectorInterface $attribute */
        foreach ($this->getAttributes() as $attribute){
            if($attribute->ableFor($scene)){
                $form->addComponent($attribute->toElement());
            }
        }
        return $form;
    }
}
