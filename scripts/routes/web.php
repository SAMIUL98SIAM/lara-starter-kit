<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();
// Route::view('/dashboard', 'backend.dashboard');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['as'=>'app.','prefix'=>'app','middleware'=>['auth']],function(){
    Route::get('/dashboard', App\Http\Controllers\Backend\DashboardController::class)->name('dashboard');

    Route::resource('roles',\App\Http\Controllers\Backend\RoleController::class);
});

