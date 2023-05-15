<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;


use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\StaysController;
use App\Http\Controllers\MyStaysController;

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

// ------------------------------ THEME ------------------------------
Route::get('/theme', function(){

  if(session('theme') == 'light')
    session(['theme' => 'dark']);
  else
    session(['theme' => 'light']);
  
  return redirect()->back();

})->name('toggle-theme');
// ------------------------------ THEME ------------------------------

// ------------------------------ LOCALE ------------------------------
Route::get('/locale/{locale}', function($locale){
  if (! in_array($locale, ['en', 'pt']))
    abort(400);
  app()->setLocale($locale);
  session(['locale' => $locale]);
  return redirect()->back();
})->name('language');
// ------------------------------ LOCALE ------------------------------

// ------------------------------ ROUTES ------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::name('sign')->group(function(){
  
  Route::get('/signin', [UserController::class, 'signin'])->name('in');
  Route::get('/signout', [UserController::class, 'signout'])->name('out');
  Route::get('/signup', [UserController::class, 'signup'])->name('up');
  
  Route::post('/signin', [UserController::class, 'signing_in'])->name('ing-in');
  Route::post('/signup', [UserController::class, 'signing_up'])->name('ing-up');
  
});

Route::name('list.')->group(function(){
  Route::get('/stays', [StaysController::class, 'index'])->name('stays');
});

Route::name('creator.')->group(function(){
  Route::get('/stays/create', [StaysController::class, 'creator'])->name('stay');
  Route::get('/projects/create', [ProjectsController::class, 'creator'])->name('project');
});

Route::name('create.')->group(function(){
  Route::post('/stays/create', [StaysController::class, 'create'])->name('stay');
  Route::post('/projects/create', [ProjectsController::class, 'create'])->name('project');
});

Route::name('my.')->group(function(){
  Route::get('/my/account', [AccountController::class, 'index'])->name('account');
  Route::get('/my/projects', [ProjectsController::class, 'index'])->name('projects');
  Route::get('/my/stays', [StaysController::class, 'index'])->name('stays');
});
