<?php

use App\Livewire\Settings\{
    Appearance,
    Password,
    Profile
};

use App\Livewire\Dashboard;

use App\Livewire\RolesPermission\{
    AsignPermission,
    Permissions,
    RoleManagement,
};

use App\Livewire\Users\{
    CreateUser,
    EditUser,
    Usermanagement
};

use App\Livewire\Leaders\{
    AllLeaders,
    BinaryTreeView,
    AddLeader,
    TransferSubtree,
    MembersOfLeader,
};

use App\Livewire\MasterData\LevelBonus\Index as LevelBonusIndex;
use App\Livewire\MasterData\LevelBonus\Create as LevelBonusCreate;
use App\Livewire\MasterData\LevelBonus\Edit as LevelBonusEdit;

use App\Livewire\MasterData\RemunerationBenefit\Index as RBIndex;
use App\Livewire\MasterData\RemunerationBenefit\Create as RBCreate;
use App\Livewire\MasterData\RemunerationBenefit\Edit as RBEdit;

use App\Livewire\ActivityLog\ActivityLogTable;

use App\Livewire\KYC\KycList;
use App\Livewire\KYC\KycDetails;



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

    Route::get('/activity-log', ActivityLogTable::class)->name('activity-log');
    
    Route::get('/leaders', AllLeaders::class)->name('leaders.all');
    Route::get('/leaders-create', AddLeader::class)->name('leaders.create');
    Route::get('/binary-tree', BinaryTreeView::class)->name('binary.tree');
    Route::get('/transfer-sub-tree', TransferSubtree::class)->name('binary.transfer');
    Route::get('/.members-of-leader', MembersOfLeader::class)->name('leaders.members-of-leader');

    Route::prefix('master-data/level-bonus')->name('level-bonus.')->group(function () {
        Route::get('/', LevelBonusIndex::class)->name('index');
        Route::get('/create', LevelBonusCreate::class)->name('create');
        Route::get('/edit/{id}', LevelBonusEdit::class)->name('edit');
    });

    Route::prefix('remuneration-benefit')->name('remuneration-benefit.')->group(function () {
        Route::get('/', RBIndex::class)->name('index');
        Route::get('/create', RBCreate::class)->name('create');
        Route::get('/edit/{id}', RBEdit::class)->name('edit');
    });

    Route::prefix('kyc')->name('kyc.')->group(function () {
        Route::get('/all', KycList::class)->name('all');
        Route::get('/pending', KycList::class)->name('pending');
        Route::get('/completed', KycList::class)->name('completed');
        Route::get('/cancelled', KycList::class)->name('cancelled');
        Route::get('/details/{kyc}', KycDetails::class)->name('details');
    });
});

require __DIR__.'/auth.php';
