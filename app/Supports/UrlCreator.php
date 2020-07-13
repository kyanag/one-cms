<?php


namespace App\Supports;


use App\Admin\Grid\Interfaces\ModelInspectorInterface;
use Illuminate\Support\Facades\URL;
use function League\Uri\build;
use League\Uri\Components\Query;
use function League\Uri\parse;

/**
 * Class UrlCreator
 * @package App\Supports
 * @Annotation
 */
class UrlCreator
{

    protected $routeMain;

    private $defaultQuery = [];


    public static function createByModel($model){
        $table = $model->getTable();

        $static = new static();
        $static->routeMain = str_singular($table);

        return $static;
    }


    public static function createByInspector(ModelInspectorInterface $modelInspector){
        $static = new static();
        $static->routeMain = str_singular($modelInspector->getName());
        return $static;
    }


    public function setDefaultQuery($query = []){
        foreach ($query as $key => $value){
            $this->defaultQuery[$key] = $value;
        }
    }

    /**
     * @param $url
     * @param array $query
     * @return string
     */
    public function appendQuery($url, $query = []){
        $query = array_merge($this->defaultQuery, $query);

        if(!empty($query)){
            $components = parse($url);

            $components['query'] = (new Query($components['query']))->merge(http_build_query($query));
            $url = build($components);
        }
        return $url;
    }

    public function route($name, $parameters = [], $query = [], $absolute = true){
        $name = $this->formatName($name);
        $url = route($name, $parameters, $absolute);

        return $this->appendQuery($url, $query);
    }

    public function current($query = []){
        return $this->appendQuery(URL::current(), $query);
    }


    public function action($name, $parameters = [], $query = [], $absolute = true){
        $parameters = array_merge($this->defaultQuery, $parameters);

        $url = action($name, $parameters, $absolute);

        return $this->appendQuery($url, $query);
    }

    public function index($parameters = [], $query = [], $absolute = true){
        $route = "admin.{$this->routeMain}.index";
        return $this->route($route, $parameters, $query, $absolute);
    }

    public function store($parameters = [], $query = [], $absolute = true){
        $route = "admin.{$this->routeMain}.store";
        return $this->route($route, $parameters, $query, $absolute);
    }

    public function create($parameters = [], $query = [], $absolute = true){
        $route = "admin.{$this->routeMain}.create";
        return $this->route($route, $parameters, $query, $absolute);
    }

    public function show($parameters = [], $query = [], $absolute = true){
        $route = "admin.{$this->routeMain}.show";
        return $this->route($route, $parameters, $query, $absolute);
    }

    public function edit($parameters = [], $query = [], $absolute = true){
        $route = "admin.{$this->routeMain}.edit";
        return $this->route($route, $parameters, $query, $absolute);
    }

    public function update($parameters = [], $query = [], $absolute = true){
        $route = "admin.{$this->routeMain}.update";
        return $this->route($route, $parameters, $query, $absolute);
    }

    public function destroy($parameters = [], $query = [], $absolute = true){
        $route = "admin.{$this->routeMain}.destroy";
        return $this->route($route, $parameters, $query, $absolute);
    }

    protected function formatName($name){
        return str_replace("*", $this->routeMain, $name);
    }
}