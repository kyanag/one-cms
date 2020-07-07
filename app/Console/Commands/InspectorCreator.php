<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class InspectorCreator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:inspector {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument("table");
        /** @var \Illuminate\Database\SQLiteConnection $connection */
        $connection = Schema::getConnection();

        $table = $connection->getDoctrineSchemaManager()->listTableDetails($table);

        $classname = ucfirst(Str::singular($table->getName()));

        $modelClass = "\App\Models\\{$classname}";

        $labels = [];
        $model = new $modelClass();
        if(method_exists($model, "getLabels")){
            $labels = $model->getLabels();
        }

        $properties = array_map(function($column) use($labels){
            $name = $column->getName();

            $title = $name;
            if($comment = $column->getComment()){
                $title = $comment;
            }else if(isset($labels[$name])){
                $title = $labels[$name];
            }

            $tpl = <<<EOF
    /**
     * @FieldAttribute(
     *     label="{$title}",
     *     name="{$name}",
     *     ableTo=15,
     *     inputType="text",
     *     columnType="raw"
     * )
     */
    public \${$name};
    
EOF;
            return $tpl;
        }, $table->getColumns());

        $tpl = strtr($this->tpl(), [
            '{ClassName}' => $classname,
            '{Properties}' => implode("\n\n", $properties),
            '{ModelClass}' => $modelClass,
        ]);

        $file = app_path("Admin/Inspectors/{$classname}.php");

        if(file_exists($file)){
            $this->error("{$file}   exists!!");
            return;
        }
        file_put_contents($file, $tpl);
        $this->info("{$file} created!!");
    }

    protected function tpl(){
        $tpl = <<<EOF
<?php

namespace App\Admin\Inspectors;

use App\Admin\Annotations\FieldAttribute;
use Kyanag\Form\Toolkits\Bootstrap3\Text;
use App\Admin\Annotations\SchemaAttribute;
use App\Admin\Grid\Columns\RawColumn;

/**
 * Class {ClassName}
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="{$this->argument("table")}",
 *     name="{$this->argument("table")}",
 *     modelClass={ModelClass}
 * )
 */
class {ClassName}{

{Properties}

}
EOF;
        return $tpl;
    }
}
