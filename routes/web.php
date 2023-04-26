<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\StaysController;

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

Route::get('/theme', function(){
  if(session('theme') == 'dark')
    session(['theme' => 'light']);
  else
    session(['theme' => 'dark']);
    
  return redirect()->back();
})->name('toggle-theme');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');

Route::get('/stays', [StaysController::class, 'index'])->name('stays');

Route::name('create.')->group(function(){
  Route::get('/stays/create', [StaysController::class, 'creator'])->name('stays.create');
  Route::get('/projects/create', [ProjectsController::class, 'creator'])->name('project');
});