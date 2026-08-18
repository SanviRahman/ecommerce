<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('update_profile');
    Route::get('/password', [ProfileController::class, 'password'])->name('password');
    Route::post('/password', [ProfileController::class, 'updatePassword'])->name('update_password');

    // Admins
    Route::post('/admins/multiple-action', [AdminController::class, 'multipleAction'])->name('admins.multiple_action');
    Route::get('/admins/trash', [AdminController::class, 'trash'])->name('admins.trashed');
    Route::post('/admins/restore/{admin}', [AdminController::class, 'restore'])->name('admins.restore');
    Route::delete('/admins/force-delete/{admin}', [AdminController::class, 'forceDelete'])->name('admins.force_delete');
    Route::get('/admins/list', [AdminController::class, 'list'])->name('admins.list');
    Route::get('/admins/ajax-search', [AdminController::class, 'list'])->name('admins.ajax_search');
    Route::resource('admins', AdminController::class);

    // Roles
    Route::post('/roles/multiple-action', [RoleController::class, 'multipleAction'])->name('roles.multiple_action');
    Route::get('/roles/trash', [RoleController::class, 'trash'])->name('roles.trashed');
    Route::post('/roles/restore/{role}', [RoleController::class, 'restore'])->name('roles.restore');
    Route::delete('/roles/force-delete/{role}', [RoleController::class, 'forceDelete'])->name('roles.force_delete');
    Route::get('/roles/list', [RoleController::class, 'list'])->name('roles.list');
    Route::get('/roles/ajax-search', [RoleController::class, 'list'])->name('roles.ajax_search');
    Route::get('/roles/get-permissions', [RoleController::class, 'getPermissions'])->name('roles.get_permissions');
    Route::resource('roles', RoleController::class);

    // Permissions
    Route::post('/permissions/multiple-action', [PermissionController::class, 'multipleAction'])->name('permissions.multiple_action');
    Route::get('/permissions/trash', [PermissionController::class, 'trash'])->name('permissions.trashed');
    Route::post('/permissions/restore/{permission}', [PermissionController::class, 'restore'])->name('permissions.restore');
    Route::delete('/permissions/force-delete/{permission}', [PermissionController::class, 'forceDelete'])->name('permissions.force_delete');
    Route::get('/permissions/list', [PermissionController::class, 'list'])->name('permissions.list');
    Route::get('/permissions/ajax-search', [PermissionController::class, 'list'])->name('permissions.ajax_search');
    Route::resource('permissions', PermissionController::class);
});
