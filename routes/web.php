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
Route::get('/mail', function () {
    Mail::send('welcome', ['data'=>[]], function ($message) {
        $message->subject('mail by '.auth()->user()->name);
        $message->to('kharismatics@gmail.com');
    });
    if (Mail::failures()) { echo 'Mailer Fail'; } else { echo 'Mailer Success'; }
})->middleware('auth');
Route::get('/lang/{lang}', function ($lang) {
    auth()->user()->language = $lang;
    auth()->user()->save();
    return back();
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resources([
    'peoples' => 'PeopleController',
    'category' => 'CategoryController',
    'products' => 'ProductController',
    'transactions' => 'TransactionController',
]);
Route::get('/sales', 'ReportController@sales')->name('sales');
Route::get('/stock', 'ReportController@stock')->name('stock');
Route::get('/debt_receivable', 'ReportController@debt_receivable')->name('debt_receivable');
Route::get('/setting', 'HomeController@index')->name('setting');