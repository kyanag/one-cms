<?php

use Illuminate\Database\Seeder;

class InstallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::transaction(function(){
            $this->initUsers();

            $this->initConfig();
        });
    }


    protected function initUsers(){

    }

    protected function initConfig(){
        $configs = [
            [
                'title' => '站点名称',
                'name' => "ONECMS_TITLE",
                'help' => "站点标题",
                'value' => "OneCMS 内容管理系统",
            ],
            [
                'title' => '站点关键词',
                'name' => "ONECMS_KEYWORD",
                'help' => "SEO站点关键词",
                'value' => "OneCMS,cms,内容管理系统,php",
            ],
            [
                'title' => '站点描述',
                'name' => "ONECMS_DESC",
                'help' => "站点标题",
                'value' => "OneCMS 基于Laravel框架的CMS",
            ],
            [
                'title' => '版权信息',
                'name' => "ONECMS_COPYRIGHT",
                'help' => "站点版权信息",
                'value' => "by <a href='https://github.com/kyanag'>kyanag</a>",
            ],
            [
                'title' => '邮箱',
                'name' => "ONECMS_EMAIL",
                'help' => "联系邮箱",
                'value' => "admin@admin.com",
            ],
            [
                'title' => '站点logo',
                'name' => "ONECMS_LOGO",
                'help' => "logo图片",
                'value' => null,
            ],
            [
                'title' => '站点流量统计',
                'name' => "ONECMS_TONGJI",
                'help' => "流量统计工具，支持CNZZ/百度/51La",
                'value' => "https://hm.baidu.com/hm.js?{yourkey}",
            ],
        ];

        /** @var \App\Models\Group $group */
        $group = \App\Models\Group::query()->find(1);
        $group->configs()->saveMany(array_map(function($config){
            return new \App\Models\Config($config);
        }, $configs));
    }
}
