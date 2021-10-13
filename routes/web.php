<?php

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

// Auth
use App\Http\Controllers\OpportunitiesController;
use App\Http\Controllers\ProductController;

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

// Dashboard
Route::get('/')->name('dashboard')->uses('DashboardController')->middleware('auth');

// Users
Route::get('users')->name('users')->uses('UsersController@index')->middleware('remember', 'auth');
Route::get('users/create')->name('users.create')->uses('UsersController@create')->middleware('auth');
Route::post('users')->name('users.store')->uses('UsersController@store')->middleware('auth');
Route::get('users/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
Route::put('users/{user}')->name('users.update')->uses('UsersController@update')->middleware('auth');
Route::delete('users/{user}')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
Route::put('users/{user}/restore')->name('users.restore')->uses('UsersController@restore')->middleware('auth');

// Images
Route::get('/img/{path}', 'ImagesController@show')->where('path', '.*');



// Contacts
Route::get('contacts')->name('contacts')->uses('ContactsController@index')->middleware('remember', 'auth');
Route::get('contacts/create')->name('contacts.create')->uses('ContactsController@create')->middleware('auth');
Route::post('contacts')->name('contacts.store')->uses('ContactsController@store')->middleware('auth');
Route::get('contacts/{contact}/edit')->name('contacts.edit')->uses('ContactsController@edit')->middleware('auth');
Route::put('contacts/{contact}')->name('contacts.update')->uses('ContactsController@update')->middleware('auth');
Route::delete('contacts/{contact}')->name('contacts.destroy')->uses('ContactsController@destroy')->middleware('auth');
Route::put('contacts/{contact}/restore')->name('contacts.restore')->uses('ContactsController@restore')->middleware('auth');

Route::middleware('auth')->group(function (){

    //products
    Route::get('accounts')->name('accounts')->uses('AccountsController@index');
    Route::get('accounts/create')->name('accounts.create')->uses('AccountsController@create');
    Route::post('accounts')->name('accounts.store')->uses('AccountsController@store');
    Route::get('accounts/{account}/edit')->name('accounts.edit')->uses('AccountsController@edit');
    Route::put('accounts/{account}')->name('accounts.update')->uses('AccountsController@update');
    Route::delete('accounts/{account}')->name('accounts.destroy')->uses('AccountsController@destroy');
    Route::put('accounts/{account}/restore')->name('accounts.restore')->uses('AccountsController@restore');


    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


    Route::get('opportunities',[OpportunitiesController::class, 'index'])->name('opportunities');
    Route::get('opportunities/create', [OpportunitiesController::class, 'create'])->name('opportunities.create');
    Route::post('opportunities', [OpportunitiesController::class, 'store'])->name('opportunities.store');
    Route::get('opportunities/{opportunity}/edit', [OpportunitiesController::class, 'edit'])->name('opportunities.edit');
    Route::put('opportunities/{opportunity}', [OpportunitiesController::class, 'update'])->name('opportunities.update');
    Route::delete('opportunities/{opportunity}', [OpportunitiesController::class, 'destroy'])->name('opportunities.destroy');
    Route::put('opportunities/{opportunity}/restore', [OpportunitiesController::class, 'restore'])->name('opportunities.restore');
});


