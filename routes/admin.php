<?php

use App\Http\Controllers\Admin\AdminAddressUserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminShopController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

//name route is snake_case
Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::middleware(['admin.auth'])->group(function () {
    Route::middleware(['isLocked'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.index');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::get('/all', [AdminController::class, 'showAll'])->name('admin.show_all');
        Route::patch('/change_status', [AdminController::class, 'changeStatus'])->name('admin.change_status');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::get('/authorize', [AdminController::class, 'authorizeAdmin'])->name('admin.authorize_admins');
        Route::put('update-roles-admin', [AdminController::class, 'updateRoles'])->name('admin.update_roles');
        Route::get('/permission-admin', [AdminController::class, 'permissionAdmin'])->name('admin.permission_admins');
        Route::put('update-permission-admin', [AdminController::class, 'updatePermissions'])->name('admin.update_permissions');
        Route::group(['prefix' => 'products'], function () {
            Route::get('instock', [AdminProductController::class, 'instock'])->name('admin.product.in_stock');
            Route::get('outstock', [AdminProductController::class, 'outstock'])->name('admin.product.out_stock');
            Route::get('{id}/edit', [AdminProductController::class, 'edit'])->name('admin.product.edit');
            Route::put('{id}', [AdminProductController::class, 'update'])->name('admin.product.update');
            Route::get('create', [AdminProductController::class, 'create'])->name('admin.product.create');
            Route::post('store', [AdminProductController::class, 'store'])->name('admin.product.store');
            Route::delete('{id}', [AdminProductController::class, 'destroy'])->name('admin.product.destroy');
        });
        Route::group(['prefix' => 'shops'], function () {
            Route::get('index', [AdminShopController::class, 'index'])->name('admin.shops.index');
            Route::get('{id}/edit', [AdminShopController::class, 'edit'])->name('admin.shop.edit');
            Route::put('{id}', [AdminShopController::class, 'update'])->name('admin.shop.update');
        });
        Route::group(['prefix' => 'users'], function () {
            Route::get('index', [AdminUserController::class, 'index'])->name('admin.user.index');
            Route::get('{id}/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit');
            Route::put('{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
            Route::patch('{id}/change_status', [AdminUserController::class, 'changeStatus'])->name('admin.user.change_status');
        });
        Route::group(['prefix' => 'addresses'], function () {
            Route::post('', [AdminAddressUserController::class, 'store'])->name('admin.address.store');
        });
        Route::group(['prefix' => 'roles'], function () {
            Route::get('', [RoleController::class, 'index'])->name('admin.role.index');
            Route::post('store', [RoleController::class, 'store'])->name('admin.role.store');
            Route::get('show_authorize', [RoleController::class, 'showAuthorizeRole'])->name('admin.role.show_authorize');
            Route::put('update_permissions', [RoleController::class, 'updatePermissionsOfRoles'])->name('admin.role.update_permission');
            Route::put('{id}', [RoleController::class, 'update'])->name('admin.role.update');
            Route::delete('{id}', [RoleController::class, 'destroy'])->name('admin.role.destroy');
        });
        Route::group(['prefix' => 'permission'], function () {
            Route::get('', [PermissionController::class, 'index'])->name('admin.permission.index');
            Route::post('store', [PermissionController::class, 'store'])->name('admin.permission.store');
            Route::put('{id}', [PermissionController::class, 'update'])->name('admin.permission.update');
            Route::delete('{id}', [PermissionController::class, 'destroy'])->name('admin.permission.destroy');
        });
    });
});
