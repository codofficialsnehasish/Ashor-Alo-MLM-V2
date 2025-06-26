<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\WebApp\{
    Home,
    About,
    Contact,
    Legal,
    PhotoGallery,
    Products,
};

Route::get('/', Home::class)->name('home');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/legal', Legal::class)->name('legal');
Route::get('/photo-gallery', PhotoGallery::class)->name('photo-gallery');
Route::get('/site-products', Products::class)->name('site-products');
