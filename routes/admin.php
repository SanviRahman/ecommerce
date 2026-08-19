<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FooterLinkController;
use App\Http\Controllers\Admin\FooterSettingController;
use App\Http\Controllers\Admin\HeaderMenuItemController;
use App\Http\Controllers\Admin\HeaderSettingController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteSettingController;
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
    Route::group(['prefix' => 'admins', 'as' => 'admins.'], function () {
        Route::post('multiple-action', [AdminController::class, 'multipleAction'])->name('multiple_action');
        Route::get('trash', [AdminController::class, 'trash'])->name('trashed');
        Route::post('restore/{admin}', [AdminController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{admin}', [AdminController::class, 'forceDelete'])->name('force_delete');
        Route::get('list', [AdminController::class, 'list'])->name('list');
        Route::get('ajax-search', [AdminController::class, 'list'])->name('ajax_search');
        Route::resource('/', AdminController::class)->parameters(['' => 'admin']);
    });

    // Roles
    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::post('multiple-action', [RoleController::class, 'multipleAction'])->name('multiple_action');
        Route::get('trash', [RoleController::class, 'trash'])->name('trashed');
        Route::post('restore/{role}', [RoleController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{role}', [RoleController::class, 'forceDelete'])->name('force_delete');
        Route::get('list', [RoleController::class, 'list'])->name('list');
        Route::get('ajax-search', [RoleController::class, 'list'])->name('ajax_search');
        Route::get('get-permissions', [RoleController::class, 'getPermissions'])->name('get_permissions');
        Route::resource('/', RoleController::class)->parameters(['' => 'role']);
    });

    // Permissions
    Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
        Route::post('multiple-action', [PermissionController::class, 'multipleAction'])->name('multiple_action');
        Route::get('trash', [PermissionController::class, 'trash'])->name('trashed');
        Route::post('restore/{permission}', [PermissionController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{permission}', [PermissionController::class, 'forceDelete'])->name('force_delete');
        Route::get('list', [PermissionController::class, 'list'])->name('list');
        Route::get('ajax-search', [PermissionController::class, 'list'])->name('ajax_search');
        Route::resource('/', PermissionController::class)->parameters(['' => 'permission']);
    });

    // Site Settings
    Route::group(['prefix' => 'site-settings', 'as' => 'site-settings.'], function () {
        Route::post('multiple-action', [SiteSettingController::class, 'multipleAction'])->name('multiple_action');
        Route::get('trash', [SiteSettingController::class, 'trash'])->name('trashed');
        Route::post('restore/{site_setting}', [SiteSettingController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{site_setting}', [SiteSettingController::class, 'forceDelete'])->name('force_delete');
        Route::get('list', [SiteSettingController::class, 'list'])->name('list');
        Route::get('ajax-search', [SiteSettingController::class, 'list'])->name('ajax_search');
        Route::resource('/', SiteSettingController::class)->parameters(['' => 'site_setting']);
    });

    // Header Settings
    Route::group(['prefix' => 'header-settings', 'as' => 'header-settings.'], function () {
        Route::post('multiple-action', [HeaderSettingController::class, 'multipleAction'])->name('multiple_action');
        Route::get('trash', [HeaderSettingController::class, 'trash'])->name('trashed');
        Route::post('restore/{header_setting}', [HeaderSettingController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{header_setting}', [HeaderSettingController::class, 'forceDelete'])->name('force_delete');
        Route::get('list', [HeaderSettingController::class, 'list'])->name('list');
        Route::get('ajax-search', [HeaderSettingController::class, 'list'])->name('ajax_search');
        Route::resource('/', HeaderSettingController::class)->parameters(['' => 'header_setting']);
    });

    // Header Menu Items
    Route::group(['prefix' => 'header-menu-items', 'as' => 'header-menu-items.'], function () {
        Route::post('multiple-action', [HeaderMenuItemController::class, 'multipleAction'])->name('multiple_action');
        Route::get('trash', [HeaderMenuItemController::class, 'trash'])->name('trashed');
        Route::post('restore/{header_menu_item}', [HeaderMenuItemController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{header_menu_item}', [HeaderMenuItemController::class, 'forceDelete'])->name('force_delete');
        Route::get('list', [HeaderMenuItemController::class, 'list'])->name('list');
        Route::get('ajax-search', [HeaderMenuItemController::class, 'list'])->name('ajax_search');
        Route::resource('/', HeaderMenuItemController::class)->parameters(['' => 'header_menu_item']);
    });

    // Footer Settings
    Route::group(['prefix' => 'footer-settings', 'as' => 'footer-settings.'], function () {
        Route::post('multiple-action', [FooterSettingController::class, 'multipleAction'])->name('multiple_action');
        Route::get('trash', [FooterSettingController::class, 'trash'])->name('trashed');
        Route::post('restore/{footer_setting}', [FooterSettingController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{footer_setting}', [FooterSettingController::class, 'forceDelete'])->name('force_delete');
        Route::get('list', [FooterSettingController::class, 'list'])->name('list');
        Route::get('ajax-search', [FooterSettingController::class, 'list'])->name('ajax_search');
        Route::resource('/', FooterSettingController::class)->parameters(['' => 'footer_setting']);
    });

    // Footer Links
    Route::group(['prefix' => 'footer-links', 'as' => 'footer-links.'], function () {
        Route::post('multiple-action', [FooterLinkController::class, 'multipleAction'])->name('multiple_action');
        Route::get('trash', [FooterLinkController::class, 'trash'])->name('trashed');
        Route::post('restore/{footer_link}', [FooterLinkController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{footer_link}', [FooterLinkController::class, 'forceDelete'])->name('force_delete');
        Route::get('list', [FooterLinkController::class, 'list'])->name('list');
        Route::get('ajax-search', [FooterLinkController::class, 'list'])->name('ajax_search');
        Route::resource('/', FooterLinkController::class)->parameters(['' => 'footer_link']);
    });

});
