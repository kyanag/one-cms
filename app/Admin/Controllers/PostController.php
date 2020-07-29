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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class PostController extends _InspectorController
{
    /**
     * @var InspectorInterface
     */
    protected $foreignInspector;

    /** @var Category */
    private $category;

    public function __construct()
    {
        parent::__construct();

        $category = Category::query()
            ->where("id", app("request")->input("category_id"))
            ->first();
        if(is_null($category)){
            throw new \Exception("不存在的栏目分类");
        }
        $this->category = $category;

        $this->foreignInspector = $this->inspector->getRelations()[$this->category['type']]->getForeignInspector();
    }

    protected function createInspector()
    {
        return app(\App\Admin\Grid\InspectorBuilder::class)
            ->from(new \App\Admin\Inspectors\Post())
            ->built();
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

        DB::transaction(function() use($request){
            $rules = [];
            $labels = [];
            /** @var AttributeInspectorInterface $attribute */
            foreach ($this->inspector->getAttributes() as $attribute){
                if($attribute->ableFor(FieldAttribute::ABLE_SHOW)){
                    $rules[$attribute->getName()] = $attribute->getRules();
                }
            }
            /** @var AttributeInspectorInterface $attribute */
            foreach ($this->foreignInspector->getAttributes() as $attribute){
                if($attribute->ableFor(FieldAttribute::ABLE_SHOW)){
                    $labels[$attribute->getName()] = $attribute->getLabel();
                }
            }
            $attributes = $this->validate(
                $request,
                $rules,
                [],
                $labels
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
        });
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
        /** @var AttributeInspectorInterface $attribute */
        foreach ($this->inspector->getAttributes() as $attribute){
            if($attribute->ableFor(FieldAttribute::ABLE_SHOW)){
                $columns[] = $attribute->toColumn();
            }
        }
        /** @var AttributeInspectorInterface $attribute */
        foreach ($this->foreignInspector->getAttributes() as $attribute){
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

        /** @var AttributeInspectorInterface $attribute */
        foreach ($this->inspector->getAttributes() as $attribute){
            if($attribute->ableFor(FieldAttribute::ABLE_SHOW)){
                $form->addComponent($attribute->toElement());
            }
        }
        /** @var AttributeInspectorInterface $attribute */
        foreach ($this->foreignInspector->getAttributes() as $attribute){
            if($attribute->ableFor(FieldAttribute::ABLE_SHOW)){
                $form->addComponent($attribute->toElement());
            }
        }
        return $form;
    }
}
