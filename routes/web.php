<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Account;
use App\Http\Controllers\Home;
use App\Http\Controllers\Authentication;

use App\Http\Controllers\Projects;
use App\Http\Controllers\Stays;

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

Route::get('/', [Projects::class, 'index'])->name('main');
Route::get('/home', [Home::class, 'index'])->name('home');

Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verify');

Route::name('sign')->group(function(){
  
  Route::get('/signin', [Authentication::class, 'signin'])->name('in');
  Route::get('/signout', [Authentication::class, 'signout'])->name('out');
  Route::get('/signup', [Authentication::class, 'signup'])->name('up');
  
  Route::post('/signin', [Authentication::class, 'signing_in'])->name('ing-in');
  Route::post('/signup', [Authentication::class, 'signing_up'])->name('ing-up');
  
});

Route::name('list.')->group(function(){
  Route::get('/stays', [Stays::class, 'index'])->name('stays');
});

Route::name('show.')->group(function(){
  Route::get('/stay/{id}', [Stays::class, 'show'])->name('stay');
});

Route::name('rent.')->group(function(){
  Route::get('/rent/stay/{id}', [Stays::class, 'rent'])->name('stay');
});

Route::name('renting.')->group(function(){
  Route::get('/renting/stay/{id}', [Projects::class, 'rentStay'])->name('stay');
});

Route::prefix('/my')->group(function(){
  Route::name('my.')->group(function(){
    
    Route::get('/account/recover/password', [Account::class, 'recover'])->name('password.recover');
    Route::get('/account', [Account::class, 'index'])->name('account');
    Route::get('/set/project/{id}', [Projects::class, 'set'])->name('set.project');

    Route::name('delete.')->group(function(){
      Route::get('/project/delete/{id}', [Projects::class, 'delete'])->name('project');
      Route::get('/stay/delete/{id}', [Stays::class, 'delete'])->name('stay');
    });

    Route::name('remove.')->group(function(){
      Route::get('/project/remove/stay/{id}', [Projects::class, 'removeStay'])->name('stay');
    });

    Route::name('disable.')->group(function(){
      Route::get('/my/stays/disable/{id}', [Stays::class, 'disable'])->name('stay');
    });

    Route::name('enable.')->group(function(){
      Route::get('/my/stays/enable/{id}', [Stays::class, 'enable'])->name('stay');
    });

    Route::name('editor.')->group(function(){
      Route::get('/stays/edit/{id}', [Stays::class, 'editor'])->name('stay');
      Route::get('/projects/edit/{id}', [Projects::class, 'editor'])->name('project');
      Route::get('/account/edit/', [Account::class, 'editor'])->name('account');
    });

    Route::name('edit.')->group(function(){
      Route::put('/stays/edit/{id}', [Stays::class, 'edit'])->name('stay');
      Route::put('/projects/edit/{id}', [Projects::class, 'edit'])->name('project');
      Route::put('/account/edit/', [Account::class, 'edit'])->name('account');
    });

    Route::name('creator.')->group(function(){
      Route::get('/stays/create', [Stays::class, 'creator'])->name('stay');
      Route::get('/projects/create', [Projects::class, 'creator'])->name('project');
    });
    
    Route::name('create.')->group(function(){
      Route::post('/stays/create', [Stays::class, 'create'])->name('stay');
      Route::post('/projects/create', [Projects::class, 'create'])->name('project');
    });

    Route::name('list.')->group(function(){
      Route::get('/projects', [Projects::class, 'list'])->name('projects');
      Route::get('/stays', [Stays::class, 'list'])->name('stays');
    });

  });
});
