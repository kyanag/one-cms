<?php

namespace App\Console\Commands;

use App\Models\Config;

class ConfigCreator extends InspectorCreator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'config:generate';

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
        $configs = Config::query()->get();

        $properties = $configs->map(function($config){
            $name = $config['name'];
            $title = $config['title'];

            $tpl = <<<EOF
    /**
     * @FieldAttribute(
     *     label="{$title}",
     *     name="{$name}",
     *     ableTo=15,
     *     input=@BuildableObjectAttribute(
     *         provider="input",
     *         name="text"
     *     ),
     *     column=@BuildableObjectAttribute(
     *         provider="column",
     *         name="raw"
     *     )
     * )
     */
    public \${$name};
    
EOF;
            return $tpl;
        });

        $classname = "ConfigItems";
        $tpl = strtr($this->tpl(), [
            '{ClassName}' => $classname,
            '{Properties}' => $properties->implode("\n\n"),
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
use App\Admin\Annotations\BuildableObjectAttribute;
use App\Admin\Annotations\SchemaAttribute;

/**
 * Class {ClassName}
 * @package App\Admin\Inspectors
 * @SchemaAttribute(
 *     title="配置管理",
 *     name="#"
 * )
 */
class {ClassName}{

{Properties}

}
EOF;
        return $tpl;
    }
}
