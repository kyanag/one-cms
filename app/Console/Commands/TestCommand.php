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

        $a = "a.exe";
        var_dump(ext);
        var_dump(range(0, 5));exit();

        /** @var \Illuminate\Filesystem\FilesystemAdapter */
        var_dump(get_class(Storage::disk("public")));
//        $categoryBuilder = new Categories();
//
//        foreach ($categoryBuilder->toArray() as $item){
//            echo str_repeat(" - ", $item['depth']) . "{$item['title']}\n";
//        }
    }
}
