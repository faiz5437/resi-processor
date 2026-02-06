<?php

use Illuminate\Support\Facades\Route;

// Shipping Label Processor - Homepage
Route::get('/', function () {
    return view('shipping-label');
})->name('home');

// Alternative route
Route::get('/shipping-label', function () {
    return view('shipping-label');
})->name('shipping-label');
