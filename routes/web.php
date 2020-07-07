<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});



Route::post("/image", "ImageController@store")->name("image.store");    //文件上传

Route::get("/image/worktable", "ImageController@worktable")->name("image.worktable");
Route::post("/image/headmatting", "ImageController@headmatting")->name("image.headmatting");