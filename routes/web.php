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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/admin', 'AdminController@index');
Route::get('/adminLogin', 'Auth\AdminLoginController@showLoginForm');
Route::post('/adminLoginSubmit', 'Auth\AdminLoginController@login');
Route::get('/adminLogout', 'Auth\AdminLoginController@logout');

Route::get('/adminChangePassword', 'AdminController@adminChangePassword');
Route::post('/adminChangeRequest', 'AdminController@adminChangeRequest');

Route::get('/users', 'AdminController@userIndex');
Route::get('/activateUser/{id}', 'AdminController@activateUser');
Route::get('/deactivateUser/{id}', 'AdminController@deactivateUser');
Route::get('/deleteUser/{id}', 'AdminController@deleteUser');
Route::get('/showUserPassword', 'AdminController@showPassword');


Route::get('/adminOrders', 'AdminController@orders');
Route::get('/adminViewOrder/{id}', 'AdminController@adminViewOrder');
Route::get('/adminSearchByCustomer', 'AdminController@searchByCustomer');
Route::get('/adminSearchByOrder', 'AdminController@searchByOrder');
Route::get('/adminSearchByShop', 'AdminController@searchByShop');
Route::get('/adminAdvanceSearch', 'AdminController@advanceSearch');
Route::get('/exportOrdersList', 'AdminController@exportOrders');
//------------------------------------------------------------------//

Route::get('/register', 'RegisterController@showForm');

Route::post('/reg', 'RegisterController@reg');

Route::get('/home', 'HomeController@index');

Route::get('/changePassword', 'HomeController@changePassword');

Route::post('/changeRequest', 'HomeController@changeRequest');

Route::get('/userLogout', 'Auth\LoginController@userLogout');

Route::get('/shops', 'ShopController@index');

Route::post('/addShop', 'ShopController@add');

Route::get('/editShop/{id}', 'ShopController@edit');

Route::post('/updateShop', 'ShopController@update');

Route::get('/deletetShop/{id}', 'ShopController@delete');

//------------------------------------------------------------------//

Route::get('/lists', 'ListController@index');

Route::get('/cities', 'ListController@cities');
Route::post('/addCity', 'ListController@addCity');
Route::get('/editCity', 'ListController@editCity');
Route::get('/deleteCity/{id}', 'ListController@deleteCity');

Route::get('/listItems/{id}', 'ListController@listItems');

Route::post('/addItem', 'ListController@addItem');

Route::get('/editItem', 'ListController@editItem');

Route::get('/deleteItem/{id}', 'ListController@deleteItem');

Route::post('/addImgItem', 'ListController@addImgItem');

Route::post('/editImgItem', 'ListController@editImgItem');

//------------------------------------------------------------------//

Route::get('/orders', 'OrderController@index');
Route::get('/viewOrder/{id}', 'OrderController@viewOrder');
Route::post('/changeStatus', 'OrderController@changeStatus');
Route::get('/viewTimeline/{id}', 'OrderController@viewTimeline');
Route::get('/ajxChangeStatus', 'OrderController@ajxChangeStatus');
Route::get('/searchByCustomer', 'OrderController@searchByCustomer');
Route::get('/searchByOrder', 'OrderController@searchByOrder');
Route::get('/searchByShop', 'OrderController@searchByShop');
Route::get('/advanceSearch', 'OrderController@advanceSearch');

//------------------------------------------------------------------//

Route::get('/fabricLining','FabricLiningController@index');

Route::post('/addFabric','FabricLiningController@addFabric');
Route::post('/editFabric','FabricLiningController@editFabric');
Route::get('/deleteFabric/{id}','FabricLiningController@deleteFabric');

Route::post('/addLining','FabricLiningController@addLining');
Route::post('/editLining','FabricLiningController@editLining');
Route::get('/deleteLining/{id}','FabricLiningController@deleteLining');

//------------------------------------------------------------------//

Route::get('/garment','GarmentController@index');
Route::get('/changeCosumption','GarmentController@changeCosumption');

Route::post('/addBaseSize','GarmentController@addBaseSize');
Route::get('/changeBaseSize','GarmentController@changeBaseSize');
Route::get('/deleteBaseSize/{id}','GarmentController@deleteBaseSize');

Route::post('/addBasePattern','GarmentController@addBasePattern');
Route::get('/changeBasePattern','GarmentController@changeBasePattern');
Route::get('/deleteBasePattern/{id}','GarmentController@deleteBasePattern');