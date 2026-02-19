<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CallbackController;


Route::middleware(['throttle:onlineStore'])->group(function () {

    Route::get('/chat', ChatController::class);
   
    Route::get('/all', [ProductController::class, 'allProducts'])->name('allProducts');

    Route::middleware('guest')->group(function () {

        Route::get('/register', [UserController::class, 'create'])->name('register.create');
        Route::post('/register', [UserController::class, 'store'])->name('register.store');
        Route::get('/login', [UserController::class, 'loginForm'])->name('login');
        Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
    });

    Route::get('/basket', [BasketController::class, 'basket'])->name('basket');
    Route::post('/basket/add/{id}', [BasketController::class, 'basketAdd'])->name('basket.add');
    Route::get('/basket/place', [BasketController::class, 'basketPlace'])->name('basket.place');
    Route::post('/basket/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket.remove');
    Route::post('/basket/remove-all/{product}', [BasketController::class, 'basketRemoveAll'])->name('basket.remove-all');



    Route::middleware('auth')->group(function () {


        Route::get('/logout', [UserController::class, 'logOut'])->name('logout');
        Route::get('/order', [UserController::class, 'orders'])->name('orders');
        Route::get('/orders', [UserController::class, 'allOrders'])->name('all.orders');
        Route::put('orders/{order}/status', [UserController::class, 'changeStatus'])->name('status.orders');



        Route::post('/basket/place', [BasketController::class, 'basketConfirm'])->name('basket.confirm');

        Route::any('/posts', [PostController::class, 'index'])->name('post.home');
        Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
        Route::any('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    Route::get('forgot-password', [UserController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [UserController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [UserController::class, 'reset'])->name('password.update');




    Route::post('/callback', [CallbackController::class, 'store'])->name('callback.store');
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/search', [ProductController::class, 'search'])->name('search');

    Route::get('/categories', [ProductController::class, 'categories'])->name('categories');
    Route::get('/categories/{category}', [ProductController::class, 'category'])->name('category');


    Route::get('/categories/{category}/{product}', [ProductController::class, 'productDetails'])->name('productDetails');
});
