<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/demo', [App\Http\Controllers\HomeController::class, 'demo']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('order');

Auth::routes();

Route::get('/user', [App\Http\Controllers\User\UserController::class, 'index'])->name('user');

Route::get('/user/create_view', [App\Http\Controllers\User\UserController::class, 'createView'])->name('user.create_view');

Route::post('/user/create', [App\Http\Controllers\User\UserController::class, 'create'])->name('user.create');

Route::get('/user/enable/{id}', [App\Http\Controllers\User\UserController::class, 'enable'])->name('user.enable');

Route::get('/user/delete/{id}', [App\Http\Controllers\User\UserController::class, 'delete'])->name('user.delete');

Route::get('/order/index/{type?}', [App\Http\Controllers\Order\OrderController::class, 'index'])->name('order');

Route::post('/order/import', [App\Http\Controllers\Order\OrderController::class, 'import'])->name('order.import');

Route::get('/order/loading', [App\Http\Controllers\Order\OrderController::class, 'loading'])->name('order.loading');

Route::get('/order/export/{type}/{model}', [App\Http\Controllers\Order\OrderController::class, 'export'])->name('order.export');
