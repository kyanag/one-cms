<?php


namespace App\Admin\Components;


use App\Admin\Annotations\FieldAttribute;
use App\Admin\Grid\Interfaces\InspectorInterface;
use App\Admin\Grid\Interfaces\FieldInspectorInterface;
use App\Supports\UrlCreator;
use Kyanag\Form\Renderable;

class ActionBar implements Renderable
{

    protected $buttons = [];

    protected $urlCreator;

    protected $inspector;

    protected $searchBar;

    protected $query = [];

    public function __construct(InspectorInterface $inspector, UrlCreator $urlCreator)
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
            'sortableFields' => array_filter($this->inspector->getFields(), function(FieldInspectorInterface $fieldInspector){
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
        $fields = array_filter($this->inspector->getFields(), function(FieldInspectorInterface $column){
            return $column->ableFor(FieldAttribute::ABLE_SEARCH);
        });

        $scope = function(\Illuminate\Database\Eloquent\Builder $query) use($fields){
            /** @var FieldInspectorInterface $field */
            foreach($fields as $field){
                if(isset($this->query[$field->getName()]) && $this->query[$field->getName()] !== ""){
                    $query->where($field->getName(), "like", "%{$this->query[$field->getName()]}%");
                }
            }
            if(isset($this->query[ORDER_BY_QUERY_NAME])){
                @list($field, $type) = explode("@", $this->query[ORDER_BY_QUERY_NAME]);
                $type = $type ?: "desc";
                $field = $field ?: null;

                switch ($type){
                    case "desc":
                        $query->orderByDesc($field);
                        break;
                    case "asc":
                        $query->orderBy($field);
                        break;
                }
            }
            return $query;
        };
        return $scope;
    }
}