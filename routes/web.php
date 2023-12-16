<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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
 // return view('welcome');
 return view('pages.auth.login');
});

Route::middleware(['auth'])->group(function(){
    Route::get('home', function(){
        return view('pages.dashboard',['type_menu'=>'']);
    })->name('home');
    Route::resource('user',UserController::class);
    // Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::resource('product',ProductController::class);
});
