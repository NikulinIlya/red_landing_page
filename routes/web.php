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

/*
 * группа маршрутов пользовательской части
 */
Route::group([], function () {
    Route::match(['get', 'post'], '/', ['uses'=>'IndexController@execute', 'as'=>'home']);
    Route::get('/page/{alias}', ['uses'=>'PageController@execute', 'as'=>'page']);
    Route::auth();
});

/*
 * группа маршрутов закрытой части
 */
Route::group(['prefix'=>'admin', 'middleware'=>'auth'], function () {

    // admin
    Route::get('/', function () {

        if(view()->exists('admin.index')) {
            $data = ['title'=>'Панель администратора'];
            return view('admin.index', $data);
        }
    });

    // admin/pages
    Route::group(['prefix'=>'pages'], function () {

        // admin/pages
        Route::get('/', ['uses'=>'PagesController@execute', 'as'=>'pages']);
        // admin/pages/add
        Route::match(['get','post'], '/add', ['uses'=>'PagesAddController@execute', 'as'=>'pagesAdd']);
        // admin/edit/2
        Route::match(['get', 'post', 'delete'], '/edit/{page}', ['uses'=>'PagesEditController@execute', 'as'=>'pagesEdit']);
    });


    Route::resource('/portfolio', 'PortfolioController', ['except' => [
        'show'
    ]]);

    Route::group(['prefix' => 'services'], function () {
        Route::get('/', ['uses' => 'ServiceController@index', 'as' => 'services']);
        Route::get('/add', ['uses' => 'ServiceController@create', 'as' => 'servicesAdd']);
        Route::post('/add', ['uses' => 'ServiceController@store', 'as' => 'servicesStore']);
        Route::get('/edit/{service}', ['uses' => 'ServiceController@edit', 'as' => 'servicesEdit']);
        Route::patch('/edit/{service}', ['uses' => 'ServiceController@update', 'as' => 'servicesUpdate']);
        Route::delete('/edit/{service}', ['uses' => 'ServiceController@delete', 'as' => 'servicesDelete']);
    });
});
