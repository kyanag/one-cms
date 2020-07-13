<?php


namespace App\Components;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Interfaces\ModelInspectorInterface;
use App\Admin\Grid\Interfaces\AttributeInspectorInterface;
use App\Supports\UrlCreator;
use Kyanag\Form\Interfaces\Renderable;

class ActionBar implements Renderable
{

    protected $buttons = [];

    protected $urlCreator;

    protected $inspector;

    protected $searchBar;

    protected $query = [];

    public function __construct(ModelInspectorInterface $inspector, UrlCreator $urlCreator)
    {
        $this->urlCreator = $urlCreator;
        $this->inspector = $inspector;
    }

    /**
     * @return UrlCreator
     */
    public function getUrlCreator(){
        return $this->urlCreator;
    }

    public function render()
    {
        return view("admin::components.action-bar", [
            'urlCreator' => $this->urlCreator,
            'searchBar' => $this->getSearchBar(),
            'sortableFields' => array_filter($this->inspector->getAttributes(), function(AttributeInspectorInterface $fieldInspector){
                return $fieldInspector->ableFor(FieldAttribute::ABLE_SORT);
            }),
        ])->render();
    }

    public function setQuery($query){
        $this->urlCreator->setDefaultQuery($query);

        $this->query = $query;
        $this->getSearchBar()->setValue($query);
    }

    /**
     * @return SearchBar
     */
    public function getSearchBar(){
        if(!$this->searchBar){
            $this->searchBar = new SearchBar($this->inspector);
        }
        return $this->searchBar;
    }

    public function toScope(){
        $fields = array_filter($this->inspector->getAttributes(), function(AttributeInspectorInterface $column){
            return $column->ableFor(FieldAttribute::ABLE_SEARCH);
        });

        $scope = function(\Illuminate\Database\Eloquent\Builder $query) use($fields){
            /** @var AttributeInspectorInterface $field */
            foreach($fields as $field){
                if(isset($this->query[$field->getName()]) && $this->query[$field->getName()] !== ""){
                    $query->where($field->getName(), "like", "%{$this->query[$field->getName()]}%");
                }
            }
            if(isset($this->query[DESC_QUERY_NAME])){
                $query->orderByDesc($this->query[DESC_QUERY_NAME]);
            }else if(isset($this->query[ASC_QUERY_NAME])){
                $query->orderBy($this->query[ASC_QUERY_NAME]);
            }
            return $query;
        };
        return $scope;
    }
}