<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home', [
    'shop' => config('shop.name'),
    'preorderUrl' => config('shop.preorder_url'),
    'flowers' => config('shop.flowers'),
    'wrappings' => config('shop.wrappings'),
    'instagram' => config('shop.instagram'),
    'phone' => config('shop.phone'),
]))->name('home');
