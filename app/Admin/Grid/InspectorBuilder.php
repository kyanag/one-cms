<?php


namespace App\Admin\Grid;

use App\Admin\Annotations\FieldAttribute;
use App\Admin\Annotations\RelationAttribute;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Supports\ClassAnnotationReader;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class InspectorFactory
 * @package App\Admin\Grid
 */
class InspectorBuilder
{

    protected $columnFactory;

    protected $elementFactory;

    /**
     * @var ClassAnnotationReader
     */
    protected $classAnnotationReader;

    public function __construct(ColumnFactory $columnFactory, ElementFactory $elementFactory)
    {
        $this->columnFactory = $columnFactory;
        $this->elementFactory = $elementFactory;
    }


    public function from($metaObject){
        $this->classAnnotationReader = new ClassAnnotationReader($metaObject);
        return $this;
    }

    /**
     * @param $related bool 是否加载关系,可以防止循环引用
     * @return InspectorAdapter
     */
    public function built($related = true){
        $schemaAttribute = $this->classAnnotationReader->getClassAnnotation(SchemaAttribute::class);

        $fieldAttributes = $this->classAnnotationReader->getPropertyAnnotations(FieldAttribute::class);

        $inspector = new InspectorAdapter($schemaAttribute);

        $fieldInspectors = array_map(function(FieldAttribute $fieldAttribute) use($inspector){
            return new FieldInspectorAdapter(
                $fieldAttribute,
                $inspector,
                $this->elementFactory,
                $this->columnFactory
            );
        }, $fieldAttributes);

        $relationInspectors = [];
        if($related){
            $inspectorBuilder = clone $this;
            $relationInspectors = array_map(function (RelationAttribute $attribute) use($inspector, $inspectorBuilder){
                $foreignInspectorAttributeClass = $attribute->related;

                $foreignInspectorAttributeObject = new $foreignInspectorAttributeClass;
                return new RelationInspectorAdapter($attribute, $inspector, $inspectorBuilder->from($foreignInspectorAttributeObject)->built(false));
            }, $schemaAttribute->relations);
        }

        $inspector->setFieldInspectors($fieldInspectors);
        $inspector->setRelationInspectors($relationInspectors);
        return $inspector;
    }
}