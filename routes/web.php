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

//TOP PAGE
// Route::get('/', function () {
//     return view('top');
// });

Route::resource('/', 'TopController');




//Route::get('top','TopController@index');

//商品詳細ページ
Route::get('/detail', function () {
    return view('items/detail');
});

//会員ログイン
Route::get('/login', function () {
    return view('entry/login');
});

//会員登録
Route::get('/regist', function () {
    return view('entry/regist');
});



//管理者
Route::resource('admin', 'ProductController');

// Route::get('/admin/show', function () {
//     return view('admin/show');
// });

// Route::get('/admin/menu', function () {
//     return view('admin/menu');
// });

//管理者を登録
// Route::get('/admin/edit', function () {
//     return view('admin/edit');
// });

// //管理者　商品登録
// Route::get('/admin/product', function () {
//     return view('admin/product');
// });

//Route::get('admin','admin.TopController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');