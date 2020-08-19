<?php

Route::get("/", function(){
    return redirect()->route("admin.home");
});
Route::get("session/create", "SessionController@loginEntry")->name("admin.session.loginEntry");
Route::post("session", "SessionController@login")->name("admin.session.login");
Route::delete("session", "SessionController@logout")->name("admin.session.logout");

Route::group([], function () {
    Route::get("home", "MainController@home")->name("admin.home");

    Route::resource("category", "CategoryController")->names("admin.category");

    Route::resource("member", "MemberController")->names("admin.member");

    Route::resource("group", "GroupController")->names("admin.group");

    Route::resource("user", "UserController")->names("admin.user");

    Route::get("config/preview", "ConfigController@preview")->name("admin.config.preview");
    Route::put("config/updateAll", "ConfigController@updateAll")->name("admin.config.updateAll");
    Route::resource("config", "ConfigController")
        ->names("admin.config")
        ->only(['create', "store", "destroy"]);

    Route::get("post/preview", "PostPreviewAction")->name("admin.post.preview");
    Route::resource("post", "PostController")
        ->names("admin.post");

    Route::delete("session", "SessionController@logout")->name("admin.session.logout");
});