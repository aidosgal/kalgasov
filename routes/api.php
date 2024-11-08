<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

Route::post("/login", [UserController::class, "login"]);
Route::post("/register", [UserController::class, "register"]);

Route::prefix("/user")->group(function () {
    Route::get("/", [UserController::class, "index"]);
    Route::get("/{id}", [UserController::class, "show"]);
    Route::put("/{id}", [UserController::class, "update"]);
});

Route::prefix("/post")->group(function () {
    Route::get("/", [PostController::class, "index"]);
    Route::post("/", [PostController::class, "create"]);
    Route::put("/{id}", [PostController::class, "update"]);
    Route::delete("/{id}", [PostController::class, "delete"]);
});

Route::prefix("/store")->group(function () {
    Route::get("/", [StoreController::class, "index"]);
    Route::get("/{id}", [StoreController::class, "show"]);
    Route::post("/", [StoreController::class, "create"]);
    Route::put("/{id}", [StoreController::class, "update"]);
    Route::delete("/{id}", [StoreController::class, "delete"]);
});

Route::prefix("/product")->group(function () {
    Route::get("/", [ProductController::class, "index"]);
    Route::get("/{id}", [ProductController::class, "show"]);
    Route::post("/", [ProductController::class, "create"]);
    Route::put("/{id}", [ProductController::class, "update"]);
    Route::delete("/{id}", [ProductController::class, "delete"]);
});

Route::prefix("/comment")->group(function () {
    Route::post("/", [CommentController::class, "create"]);
    Route::put("/{id}", [CommentController::class, "update"]);
    Route::delete("/{id}", [CommentController::class, "delete"]);
});

Route::prefix("/like")->group(function () {
    Route::post("/", [LikeController::class, "create"]);
    Route::delete("/", [LikeController::class, "delete"]);
});
