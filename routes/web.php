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

// Organizations
//Route::get('organizations')->name('organizations')->uses('OrganizationsController@index')->middleware('remember', 'auth');
//Route::get('organizations/create')->name('organizations.create')->uses('OrganizationsController@create')->middleware('auth');
//Route::post('organizations')->name('organizations.store')->uses('OrganizationsController@store')->middleware('auth');
//Route::get('organizations/{organization}/edit')->name('organizations.edit')->uses('OrganizationsController@edit')->middleware('auth');
//Route::put('organizations/{organization}')->name('organizations.update')->uses('OrganizationsController@update')->middleware('auth');
//Route::delete('organizations/{organization}')->name('organizations.destroy')->uses('OrganizationsController@destroy')->middleware('auth');
//Route::put('organizations/{organization}/restore')->name('organizations.restore')->uses('OrganizationsController@restore')->middleware('auth');

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


    Route::get('products')->name('products')->uses('ProductController@index');
    Route::get('products/create')->name('products.create')->uses('ProductController@create');
    Route::post('products')->name('products.store')->uses('ProductController@store');
    Route::get('products/{product}/edit')->name('products.edit')->uses('ProductController@edit');
    Route::put('products/{product}')->name('products.update')->uses('ProductController@update');
    Route::delete('products/{product}')->name('products.destroy')->uses('ProductController@destroy');
    Route::put('products/{product}/restore')->name('products.restore')->uses('ProductController@restore');

    Route::get('opportunities')->name('opportunities')->uses('OpportunitiesController@index');
    Route::get('opportunities/create')->name('opportunities.create')->uses('OpportunitiesController@create');
    Route::post('opportunities')->name('opportunities.store')->uses('OpportunitiesController@store');
    Route::get('opportunities/{opportunity}/edit')->name('opportunities.edit')->uses('OpportunitiesController@edit');
    Route::put('opportunities/{opportunity}')->name('opportunities.update')->uses('OpportunitiesController@update');
    Route::delete('opportunities/{opportunity}')->name('opportunities.destroy')->uses('OpportunitiesController@destroy');
    Route::put('opportunities/{opportunity}/restore')->name('opportunities.restore')->uses('OpportunitiesController@restore');
});

// Reports
Route::get('reports')->name('reports')->uses('ReportsController')->middleware('auth');

// 500 error
Route::get('500', function () {
    echo $fail;
});
