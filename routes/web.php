<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('products.index');
    } else {
        return redirect()->route('login');
    }
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('products', ProductController::class);
});


Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/productSubmit',[App\Http\Controllers\ProductController::class, 'productSubmit'])->name('productSubmit');
Route::get('/create', [App\Http\Controllers\ProductController::class, 'create'])->name('create');
Route::get('/show', [App\Http\Controllers\ProductController::class, 'show'])->name('show');
Route::get('/index', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('search');