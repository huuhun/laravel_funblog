<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function(){ //1 cái check đã login, 1 cái check có phải admin ko


    Route::get("/dashboard",[App\Http\Controllers\Admin\DashboardController::class, 'index']);

    Route::get("/category",[App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get("/add-category",[App\Http\Controllers\Admin\CategoryController::class, 'create']);//ui
    Route::post("/add-category",[App\Http\Controllers\Admin\CategoryController::class, 'store']);//real

    Route::get("/category/edit-category/{category_id}",[App\Http\Controllers\Admin\CategoryController::class, 'edit']);//ui
    Route::put("/category/update-category/{category_id}",[App\Http\Controllers\Admin\CategoryController::class, 'update']);//real
    Route::get("/category/delete-category/{category_id}",[App\Http\Controllers\Admin\CategoryController::class, 'destroy']);//real


    Route::get("/post",[App\Http\Controllers\Admin\PostController::class, 'index']);//ui
    Route::get("/add-post",[App\Http\Controllers\Admin\PostController::class, 'create']);//ui
    Route::post("/add-post",[App\Http\Controllers\Admin\PostController::class, 'store']);//real

    Route::get("/post/edit-post/{post_id}",[App\Http\Controllers\Admin\PostController::class, 'edit']);//ui
    Route::put("/post/update-post/{post_id}",[App\Http\Controllers\Admin\PostController::class, 'update']);//real
    Route::get("/post/delete-post/{post_id}",[App\Http\Controllers\Admin\PostController::class, 'destroy']);


    Route::get("/user",[App\Http\Controllers\Admin\UserController::class, 'index']);

    Route::get("/user/edit-user/{user_id}",[App\Http\Controllers\Admin\UserController::class, 'edit']);
    Route::put("/user/update-user/{user_id}",[App\Http\Controllers\Admin\UserController::class, 'update']);

});
