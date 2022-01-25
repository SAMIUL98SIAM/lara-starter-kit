<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PageController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['as' => 'login.', 'prefix' => 'login'], function () {
    Route::get('/github', [LoginController::class, 'redirectToGithub'])->name('github');
    Route::get('/github/callback', [LoginController::class, 'handleGithubCallback'])->name('callback');

    Route::get('/google', [LoginController::class, 'redirectToGoogle'])->name('google');
    Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('callback');

    Route::get('/facebook', [LoginController::class, 'redirectToFacebook'])->name('facebook');
    Route::get('/facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('callback');
});



//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/{slug}',[PageController::class,'index'])->name('page');

