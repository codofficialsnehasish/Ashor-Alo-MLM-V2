<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;

use App\Livewire\Dashboard;

use App\Livewire\RolesPermission\AsignPermission;
use App\Livewire\RolesPermission\Permissions;
use App\Livewire\RolesPermission\RoleManagement;

use App\Livewire\Users\CreateUser;
use App\Livewire\Users\EditUser;
use App\Livewire\Users\Usermanagement;

use App\Livewire\BinaryTreeView;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', function () {
    return redirect(route('login'));
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('/roles', RoleManagement::class)->name('role');
    Route::get('/permissions', Permissions::class)->name('permissions');
    Route::get('permissions/{roleId}/asign-permissions', AsignPermission::class)->name('permissions.asign');

    Route::get('/users', Usermanagement::class)->name('users');
    Route::get('/users/create' , CreateUser::class)->name('createUser');
    Route::get('/users/{id}/edit', EditUser::class)->name('user.edit');

    Route::get('/binary-tree', BinaryTreeView::class)->name('binary.tree');
});

require __DIR__.'/auth.php';
