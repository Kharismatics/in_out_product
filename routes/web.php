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
Route::get('password/setting', 'HomeController@showChangeForm')->name('setting')->middleware('auth','localization');
Route::post('password/change', 'HomeController@change')->name('change')->middleware('auth','localization');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth','localization');
Route::resources([
    'peoples' => 'PeopleController',
    'category' => 'CategoryController',
    'products' => 'ProductController',
    'transactions' => 'TransactionController',
]);
Route::match(['get', 'post'],'/sales', 'ReportController@sales')->name('sales');
Route::match(['get', 'post'],'/debt', 'ReportController@debt')->name('debt');
Route::post('/sales_chart', 'HomeController@sales_chart')->name('sales_chart');
Route::post('/purchase_chart', 'HomeController@purchase_chart')->name('purchase_chart');
Route::post('/best_product_chart', 'HomeController@best_product_chart')->name('best_product_chart');
Route::post('/best_customer_chart', 'HomeController@best_customer_chart')->name('best_customer_chart');
Route::get('/stocks', 'ReportController@stocks')->name('stocks');
Route::get('/stock/{product}', 'ReportController@stock')->name('stock');
Route::get('/debt_receivable', 'ReportController@debt_receivable')->name('debt_receivable');