<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\MainController;

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
Route::get('/', [MainController::class, 'index'])->name('main');

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

Route::name('show.')->group(function(){
  Route::get('/stay/{id}', [StaysController::class, 'show'])->name('stay');
});

Route::name('rent.')->group(function(){
  Route::get('/rent/stay/{id}', [StaysController::class, 'rent'])->name('stay');
});

Route::name('renting.')->group(function(){
  Route::get('/renting/stay/{id}', [ProjectsController::class, 'rentStay'])->name('stay');
});

Route::prefix('/my')->group(function(){
  Route::name('my.')->group(function(){
    
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/set/project/{id}', [ProjectsController::class, 'set'])->name('set.project');

    Route::name('delete.')->group(function(){
      Route::get('/project/delete/{id}', [ProjectsController::class, 'delete'])->name('project');
      Route::get('/stay/delete/{id}', [MyStaysController::class, 'delete'])->name('stay');
    });

    Route::name('remove.')->group(function(){
      Route::get('/project/remove/stay/{id}', [ProjectsController::class, 'removeStay'])->name('stay');
    });

    Route::name('disable.')->group(function(){
      Route::get('/my/stays/disable/{id}', [MyStaysController::class, 'disable'])->name('stay');
    });

    Route::name('enable.')->group(function(){
      Route::get('/my/stays/enable/{id}', [MyStaysController::class, 'enable'])->name('stay');
    });

    Route::name('editor.')->group(function(){
      Route::get('/stays/edit/{id}', [MyStaysController::class, 'editor'])->name('stay');
      Route::get('/projects/edit/{id}', [ProjectsController::class, 'editor'])->name('project');
    });

    Route::name('edit.')->group(function(){
      Route::put('/stays/edit/{id}', [MyStaysController::class, 'edit'])->name('stay');
      Route::put('/projects/edit/{id}', [ProjectsController::class, 'edit'])->name('project');
    });

    Route::name('creator.')->group(function(){
      Route::get('/stays/create', [MyStaysController::class, 'creator'])->name('stay');
      Route::get('/projects/create', [ProjectsController::class, 'creator'])->name('project');
    });
    
    Route::name('create.')->group(function(){
      Route::post('/stays/create', [MyStaysController::class, 'create'])->name('stay');
      Route::post('/projects/create', [ProjectsController::class, 'create'])->name('project');
    });

    Route::name('list.')->group(function(){
      Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
      Route::get('/stays', [MyStaysController::class, 'index'])->name('stays');
    });

  });
});
