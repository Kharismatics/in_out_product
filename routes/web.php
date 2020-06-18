<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resources([
    'peoples' => 'PeopleController',
    'category' => 'CategoryController',
    'products' => 'ProductController',
    'transactions' => 'TransactionController',
]);
Route::get('/daily_report', 'ReportController@daily')->name('daily_report');
Route::get('/monthly_report', 'ReportController@monthly')->name('monthly_report');