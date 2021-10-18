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
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WelcomeController;

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');


Route::group(['middleware' => ['web', 'welcome.user']], function () {
    Route::get('welcome/{user}', [WelcomeController::class, 'showWelcomeForm'])
        ->name('welcome');
    Route::post('welcome/{user}', [WelcomeController::class, 'savePassword'])
        ->name('welcome.save-user');
});

Route::middleware('auth')->group(function (){

    // Dashboard
    Route::get('/')->name('dashboard')->uses('DashboardController');


    // Users
    Route::get('users', [UsersController::class, 'index'])->name('users');
    Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('users', [UsersController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');


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


