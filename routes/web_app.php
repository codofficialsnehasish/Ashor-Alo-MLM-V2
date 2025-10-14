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

use App\Livewire\WebApp\User\Auth\Login as UserLogin;
use App\Livewire\WebApp\User\Auth\Register as UserRegister;
use App\Livewire\WebApp\User\Dashboard;

// Route::get('/', Home::class)->name('home');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/legal', Legal::class)->name('legal');
Route::get('/photo-gallery', PhotoGallery::class)->name('photo-gallery');
Route::get('/site-products', Products::class)->name('site-products');


Route::prefix('user')->group(function () {

    // guest routes
    Route::middleware('guest:user')->group(function () {
        Route::get('login', UserLogin::class)->name('user.login');
        Route::get('register', UserRegister::class)->name('user.register');
        // you can also add user register, forgot password here separately
    });

    // auth routes
    Route::middleware('auth:user')->group(function () {
        Route::get('dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
        Route::post('logout', function () {
            Auth::guard('user')->logout();
            return redirect()->route('user.login');
        })->name('user.logout');
    });
});

Route::middleware(['auth:user'])->group(function () {
    Route::get('/user/dashboard', Dashboard::class)->name('user.dashboard');
});