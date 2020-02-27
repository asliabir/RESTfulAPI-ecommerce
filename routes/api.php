<?php

use Illuminate\Http\Request;

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
