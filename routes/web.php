<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('post/create', [PostController::class, 'create'])->name('posts.create');
Route::post('post/store', [PostController::class, 'store'])->name('posts.store');
Route::get('post/index', [PostController::class, 'index'])->name('posts.read');
Route::get('post/{id}/destroy', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('post/{id}/show', [PostController::class, 'show']);
Route::get('post/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('post/{id}/update', [PostController::class, 'update'])->name('posts.update');

Route::middleware(['admin'])->group(function () {
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/index', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/{id}/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
});
