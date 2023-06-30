<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Home;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Contact;
use App\Http\Controllers\Report;
use App\Http\Controllers\Localization;
use App\Http\Controllers\Verification;
use App\Http\Controllers\Account;
use App\Http\Controllers\Projects;
use App\Http\Controllers\Stays;
use App\Http\Controllers\Money;
use App\Http\Controllers\Notifications;

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

Route::get('/contact-us', [Contact::class, 'index'])->name('contact');

Route::post('/contact-us', [Contact::class, 'store'])->name('contact');


Route::name('report.')->group(function(){

  Route::get('/report/review/{id}', [Report::class, 'review'])->name('review');

});

Route::get('/recover/password', [Account::class, 'recover_password_anonymously'])->name('recover.password.anonymously');

Route::post('/recover/password', [Account::class, 'recover_password_anonymously_send'])->name('recover.password.anonymously');

Route::name('sign.')->group(function(){

  Route::get('/sign', [Authentication::class, 'index'])->name('index');

  Route::get('/signin', [Authentication::class, 'signin'])->name('in');
  
  Route::get('/signout', [Authentication::class, 'signout'])->name('out');
  
  Route::get('/signup', [Authentication::class, 'signup'])->name('up');
  
  Route::post('/signin', [Authentication::class, 'signing_in'])->name('ing-in');
  
  Route::post('/signup', [Authentication::class, 'signing_up'])->name('ing-up');
  
});

Route::name('verification.')->group(function(){

  Route::get('/verify/{token}', [Verification::class, 'verify'])->name('verify');

  Route::get('/verify/password/{token}', [Verification::class, 'password'])->name('password');

  Route::get('/verify/password/anonymously/{token}', [Verification::class, 'password_anonymously'])->name('password.anonymously');

  Route::get('/verification/success', [Verification::class, 'success'])->name('success');
  
  Route::get('/verification/error', [Verification::class, 'error'])->name('error');

});

Route::name('projects.')->group(function(){

  Route::get('/', [Projects::class, 'index'])->name('index');

  Route::get('/project/close/{id}', [Projects::class, 'close'])->name('close');

  Route::get('/project/payment/', [Projects::class, 'payment'])->name('payment');

  Route::get('/project/set/{id}', [Projects::class, 'set'])->name('set');
  
  Route::get('/project/delete/{id}', [Projects::class, 'delete'])->name('delete');

  Route::get('/projects/edit/{id}', [Projects::class, 'editor'])->name('editor');

  Route::put('/projects/edit/{id}', [Projects::class, 'edit'])->name('edit');

  Route::get('/projects/create', [Projects::class, 'creator'])->name('creator');

  Route::post('/projects/create', [Projects::class, 'create'])->name('create');

  Route::get('/projects/list', [Projects::class, 'list'])->name('list');
  
  Route::name('stays.')->group(function(){

    Route::get('/renting/stay/{id}', [Projects::class, 'rentStay'])->name('rent');

    Route::get('/project/remove/stay/{id}', [Projects::class, 'removeStay'])->name('remove');

  });

});

Route::name('stays.')->group(function(){

  Route::get('/stays', [Stays::class, 'index'])->name('index');

  Route::get('/stay/review/{id}', [Stays::class, 'reviewer'])->name('reviewer');

  Route::post('/stay/review/{id}', [Stays::class, 'review'])->name('review');

  Route::get('/stays/dashboard/{id}', [Stays::class, 'dashboard'])->name('dashboard');

  Route::get('/stay/{id}', [Stays::class, 'show'])->name('show');

  Route::get('/stay/rent/{id}', [Stays::class, 'rent'])->name('rent');

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

  Route::name('notifications.')->group(function(){

    Route::get('/account/notifications', [Notifications::class, 'index'])->name('list');

    Route::get('/account/notifications/delete/{id}', [Notifications::class, 'delete'])->name('delete');
    Route::get('/account/notifications/delete', [Notifications::class, 'deleteAll'])->name('deleteAll');

  });

  Route::delete('/account/delete/{id}', [Account::class, 'delete'])->name('delete');

  Route::name('manage.')->group(function(){
    
    Route::get('/account/manage', [Account::class, 'manage'])->name('index');

    Route::get('/account/manage/money', [Money::class, 'manage'])->name('money');
    
  });
  
  Route::name('money.')->group(function(){

    Route::get('/account/money/add', [Money::class, 'adder'])->name('adder');

    Route::get('/account/money/remove', [Money::class, 'remover'])->name('remover');

    Route::put('/account/money/add', [Money::class, 'add'])->name('add');

    Route::put('/account/money/remove', [Money::class, 'remove'])->name('remove');

  });

  Route::get('/account/edit', [Account::class, 'editor'])->name('editor');

  Route::put('/account/edit', [Account::class, 'edit'])->name('edit');

  Route::name("password.")->group(function(){

    Route::get('/account/recover/password', [Account::class, 'recover_password'])->name('recover');

    Route::get('/account/edit/password', [Account::class, 'password_editor'])->name('editor');

    Route::get('/account/edit/password/anonymously', [Account::class, 'password_editor_anonymously'])->name('editor.anonymously');

    Route::put('/account/edit/password', [Account::class, 'password_edit'])->name('edit');

    Route::put('/account/edit/password/anonymously', [Account::class, 'password_edit_anonymously'])->name('edit.anonymously');

  });

});
