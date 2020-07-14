<?php

namespace App\Console\Commands;


use App\Admin\Grid\Options\Categories;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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
        try{
            var_dump(call_user_func("static::testCall"));
        }catch (\BadMethodCallException $e){
            var_dump(2);
        }catch (\Exception $e){
            var_dump(1);
        }

    }

}
