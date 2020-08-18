<?php

namespace App\Admin\Controllers;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\InspectorAdapter;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;
use App\Admin\Supports\Factory;
use App\Admin\Supports\InspectorHelper;
use App\Admin\Components\GridView;
use App\Models\Category;
use App\Models\Post;
use App\Admin\Supports\FormBuilder;
use App\Supports\UrlCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class PostController extends _InspectorController
{
    /**
     * @var InspectorInterface
     */
    private $foreignInspector;

    /**
     * @var RelationInspectorInterface
     */
    private $relationInspector;

    /** @var Category */
    private $category;

    public function initialize()
    {
        $category = Category::query()
            ->where("id", app("request")->input("category_id"))
            ->first();
        if(is_null($category)){
            throw new \Exception("不存在的栏目分类");
        }
        $this->category = $category;

        $this->inspector = Factory::buildInspector(new \App\Admin\Inspectors\Post());

        $this->relationInspector = $this->inspector->getRelations()[$this->category['type']];
        $this->foreignInspector = $this->relationInspector->getForeignInspector();

        $urlCreator = createUrlCreator(class_basename($this));
        $urlCreator->setDefaultQuery([
            'category_id' => $this->category['id']
        ]);
        $this->urlCreator = $urlCreator;
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request  $request
     * @return Response
     * @throws HttpException
     */
    public function store(Request $request)
    {

        DB::transaction(function() use($request){
            $rules = [];
            $labels = [];
            /** @var FieldInspectorInterface $attribute */
            foreach ($this->inspector->getFields() as $attribute){
                if($attribute->ableFor(FieldAttribute::ABLE_CREATE)){
                    $rules[$attribute->getName()] = $attribute->getRules();
                    $labels[$attribute->getName()] = $attribute->getLabel();
                }
            }
            /** @var FieldInspectorInterface $attribute */
            foreach ($this->foreignInspector->getFields() as $attribute){
                if($attribute->ableFor(FieldAttribute::ABLE_CREATE)){
                    $rules[$attribute->getName()] = $attribute->getRules();
                    $labels[$attribute->getName()] = $attribute->getLabel();
                }
            }
            $attributes = $this->validate(
                $request,
                $rules,
                [],
                $labels
            );

            /** @var Post $model */
            $model = InspectorHelper::newModel($this->inspector);
            $model->fill(
                InspectorHelper::filterByInspector($this->inspector, $attributes, FieldAttribute::ABLE_CREATE)
            );
            //设置数据栏目
            $model->category_id = $this->category['id'];

            $foreignModel = InspectorHelper::newModel($this->foreignInspector);
            $foreignModel->fill(
                InspectorHelper::filterByInspector($this->foreignInspector, $attributes, FieldAttribute::ABLE_CREATE)
            );
            $relationName = $this->category['type'];

            if($model->saveOrFail() && $model->{$relationName}()->save($foreignModel)){
                return response()->json([
                    'msg' => "保存成功!",
                    'jump' => $this->urlCreator->index(),
                ]);
            }else{
                throw new ServiceUnavailableHttpException();
            }
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        /** @var Model $model */
        $model = $this->newQuery()->find($id);
        if(is_null($model)){
            throw new NotFoundHttpException("不存在的内容!");
        }

        DB::transaction(function() use($model){
            $foreignModel = $model->getRelation($this->category['type']);

            if(!$model->delete()){
                throw new ServiceUnavailableHttpException("删除过程失败，请重试!");
            }
            if(!$foreignModel->delete()){
                throw new ServiceUnavailableHttpException("删除失败，请重试!");
            }
        });
        return response()->json([
            'msg' => "删除成功!",
            'jump' => $request->header("REFERER"),
        ]);
    }

    protected function newQuery()
    {
        return $this->newModel()
            ->newQuery()
            ->with($this->category['type']);
    }


    protected function getGrid()
    {
        $columns = [];
        /** @var FieldInspectorInterface $attribute */
        foreach ($this->inspector->getFields() as $attribute){
            if($attribute->ableFor(FieldAttribute::ABLE_SHOW)){
                $columns[] = $attribute->toColumn();
            }
        }
        /** @var FieldInspectorInterface $attribute */
        foreach ($this->foreignInspector->getFields() as $attribute){
            if($attribute->ableFor(FieldAttribute::ABLE_SHOW)){
                $columns[] = $attribute->toColumn();
            }
        }

        $gridView = GridView::create([
            'caption' => "{$this->inspector->getTitle()} 列表",
            'columns' => $columns,
        ]);
        return $gridView;
    }

    public function getForm($scene)
    {
        $form = FormBuilder::newForm();

        /** @var FieldInspectorInterface $attribute */
        foreach ($this->inspector->getFields() as $attribute){
            if($attribute->ableFor($scene)){
                $element = $attribute->toElement();
                if(is_null($element)){
                    throw new \Exception("{$attribute->getName()} 没有表单组件");
                }
                $form->addChild($element);
            }
        }
        /** @var FieldInspectorInterface $attribute */
        foreach ($this->foreignInspector->getFields() as $attribute){
            if($attribute->ableFor($scene)){
                $element = $attribute->toElement();
                if(is_null($element)){
                    throw new \Exception("{$attribute->getName()} 没有表单组件");
                }
                $form->addChild($element);
            }
        }
        return $form;
    }
}
