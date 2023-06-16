<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Home;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Localization;
use App\Http\Controllers\Validation;
use App\Http\Controllers\Account;
use App\Http\Controllers\Projects;
use App\Http\Controllers\Stays;

/** 
 *  Naming conventions:
 * 'Index' for the main route, like listing all stays for a country
 * 'Show' for apresenting something, like showing a stay
 * 'List' for listing all stays for a user (private)
 * 'Create' for creating something (private)
 * 'Edit' for editing something (private)
 * 'Delete' for deleting something (private)
 * 'Disable' and 'Enable' for disabling or enabling something (private)
 * 'Sign' for signin, signout and signup
 */

Route::get('/home', [Home::class, 'index'])->name('home');

Route::get('/locale/{locale}', [Localization::class, 'index'])->name('language');

Route::name('sign')->group(function(){
  Route::get('/signin', [Authentication::class, 'signin'])->name('in');
  Route::get('/signout', [Authentication::class, 'signout'])->name('out');
  Route::get('/signup', [Authentication::class, 'signup'])->name('up');

  Route::post('/signin', [Authentication::class, 'signing_in'])->name('ing-in');
  Route::post('/signup', [Authentication::class, 'signing_up'])->name('ing-up');
});

Route::get('/verify/{token}', [Validation::class, 'verify'])->name('verify');

Route::name('projects.')->group(function(){

  Route::get('/', [Projects::class, 'index'])->name('index');

  Route::get('/project/set/{id}', [Projects::class, 'set'])->name('set');
  
  Route::get('/project/delete/{id}', [Projects::class, 'delete'])->name('delete');

  Route::get('/projects/edit/{id}', [Projects::class, 'editor'])->name('editor');

  Route::put('/projects/edit/{id}', [Projects::class, 'edit'])->name('edit');

  Route::get('/projects/create', [Projects::class, 'creator'])->name('creator');

  Route::post('/projects/create', [Projects::class, 'create'])->name('create');

  Route::get('/projects/list', [Projects::class, 'list'])->name('list');
  
  Route::name('stay.')->group(function(){
    Route::get('/renting/stay/{id}', [Projects::class, 'rentStay'])->name('rent');
    Route::get('/project/remove/stay/{id}', [Projects::class, 'removeStay'])->name('remove');
  });

});

Route::name('stays.')->group(function(){

  Route::get('/stays', [Stays::class, 'index'])->name('index');

  Route::get('/stay/{id}', [Stays::class, 'show'])->name('show');

  Route::get('/rent/stay/{id}', [Stays::class, 'rent'])->name('rent');

  Route::get('/stay/delete/{id}', [Stays::class, 'delete'])->name('delete');

  Route::get('/my/stays/disable/{id}', [Stays::class, 'disable'])->name('disable');

  Route::get('/my/stays/enable/{id}', [Stays::class, 'enable'])->name('enable');

  Route::get('/stays/edit/{id}', [Stays::class, 'editor'])->name('editor');

  Route::put('/stays/edit/{id}', [Stays::class, 'edit'])->name('edit');

  Route::get('/stays/create', [Stays::class, 'creator'])->name('creator');

  Route::post('/stays/create', [Stays::class, 'create'])->name('create');

  Route::get('/stays/list', [Stays::class, 'list'])->name('list');

});

Route::name('account.')->group(function(){

  Route::get('/account', [Account::class, 'index'])->name('index');

  Route::get('/account/recover/password', [Account::class, 'recover'])->name('password.recover');

  Route::get('/account/edit/', [Account::class, 'editor'])->name('editor');

  Route::put('/account/edit/', [Account::class, 'edit'])->name('edit');

});
