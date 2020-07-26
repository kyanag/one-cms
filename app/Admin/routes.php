<?php

Route::get("/", function(){
    return redirect()->route("admin.home");
});
Route::resource("session", "SessionController")->only(["create", "store"])->names("admin.session");

Route::group([], function () {
    Route::get("home", "MainController@home")->name("admin.home");

    Route::resource("category", "CategoryController")->names("admin.category");

    Route::resource("member", "MemberController")->names("admin.member");

    Route::resource("group", "GroupController")->names("admin.group");

    Route::get("config/preview", "ConfigController@preview")->name("admin.config.preview");
    Route::put("config/updateAll", "ConfigController@updateAll")->name("admin.config.updateAll");
    Route::resource("config", "ConfigController")
        ->names("admin.config")
        ->only(['create', "store", "destroy"]);

    Route::resource("post", "PostController")
        ->names("admin.post");

});