<?php


namespace App\Admin\Repositories;


use App\Admin\Annotations\RelationAttribute;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\RelationInspectorInterface;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException as RepositoryException;


class BasicInspectorRepository
{
    /**
     * @var InspectorInterface
     */
    protected $inspector;


    protected $activeRelations = [];


    protected $forms = [];


    public function __construct(InspectorInterface $inspector, $activeRelations = [], $forms = [])
    {
        $this->inspector = $inspector;
        $this->activeRelations = $activeRelations;
        $this->forms = $forms;
    }

    /**
     * @return Model
     */
    protected function newModel()
    {
        return new $this->inspector->getModelClass();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery(){
        return $this->newModel()->newQuery()->with($this->activeRelations);
    }

    public function find($id, $columns = ['*'])
    {
        return $this->getQuery()->select($columns)->find($id);
    }

    /**
     * @param array $attributes
     * @return Model
     * @throws RepositoryException
     */
    public function create(array $attributes)
    {
        /** @var \App\Models\Form $model */
        $model = $this->newModel();
        $model->fill($attributes);

        if(!$model->save()){
            throw new RepositoryException();
        }

        foreach ($this->activeRelations as $activeRelatedName){
            /** @var RelationInspectorInterface $relationInspector */
            $relationInspector = $this->inspector->getRelation($activeRelatedName);
            $foreignInspector = $relationInspector->getForeignInspector();

            $modelClass = $foreignInspector->getModelClass();

            if($relationInspector->getRelationshipType() === RelationAttribute::RELATION_HAS_MANY){

                foreach ($attributes[$activeRelatedName] as $attributes){
                    if(!$model->{$activeRelatedName}()->save(new $modelClass($attributes))){
                        throw new RepositoryException();
                    }
                }
            }else{
                if(!$model->{$activeRelatedName}()->save(new $modelClass($attributes[$activeRelatedName]))){
                    throw new RepositoryException();
                }
            }
        }
        return $model;
    }

    public function update(array $attributes, $id)
    {

    }

    public function updateModel(array $attributes, Model $model){
        $model->fill($attributes);
        if(!$model->save()){
            throw new RepositoryException(null, "保存失败!");
        }
        //保存附表数据
        foreach ($this->activeRelations as $activeRelationName){
            if($model->relationLoaded($activeRelationName) === false){
                $model->load($activeRelationName);
            }

            /** @var RelationInspectorInterface $relationInspector */
            $relationInspector = $this->inspector->getRelation($activeRelationName);
            $foreignInspector = $relationInspector->getForeignInspector();

            //关联模型class
            $modelClass = $foreignInspector->getModelClass();
            //关联数据
            $relationModel = $model->getRelation($activeRelationName);

            if($relationInspector->getRelationshipType() === RelationAttribute::RELATION_HAS_MANY){
                //hasMany

                $relationModels = $relationModel ?: [];

                // 外键为键值的hash数组
                $relationModels = collect($relationModels)->keyBy($foreignInspector->getPrimaryKey());

                //HasMany
                foreach ($attributes[$activeRelationName] as $relationAttribute){
                    $foreign_id = @$relationAttribute[$foreignInspector->getPrimaryKey()];
                    unset($relationAttribute[$relationInspector->getForeignKey()]);

                    if(isset($relationModels[$foreign_id])){
                        $relationModel = $relationModels[$foreign_id];

                        unset($relationModels[$foreign_id]);
                    }else{
                        /** @var Model $relationModel */
                        $relationModel = new $modelClass;
                    }

                    /** @var Model $relationModel */
                    $relationModel->fill($relationAttribute);

                    if(!$model->{$activeRelationName}()->save($relationModel)){
                        throw new RepositoryException();
                    }
                }

                if(count($relationModels) > 0){
                    //将之前没有unset掉的删掉

                    foreach ($relationModels as $relationModel){
                        /** @var Model $relationModel */
                        $relationModel->delete();
                    }
                }
            }else{
                $relationModel = $relationModel ?: new $modelClass();
                $relationModel->fill($attributes[$activeRelationName]);
                //HasOne
                if(!$model->{$activeRelationName}()->save($relationModel)){
                    throw new RepositoryException();
                }
            }
        }
        return $model;
    }


    public function deleteModel(Model $model){
        if(!$model->delete()){
            throw new RepositoryException("删除失败，请重试!");
        }
        return $model;
    }
}