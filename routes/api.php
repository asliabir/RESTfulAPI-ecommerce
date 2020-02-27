<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Buyers api routes
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
// Categories api routes
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
// Products api routes
Route::resource('productes', 'Product\ProductController', ['only' => ['index', 'show']]);
// Sellers api routes
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
// Transactions api routes
Route::resource('transections', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
// User api routes
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
