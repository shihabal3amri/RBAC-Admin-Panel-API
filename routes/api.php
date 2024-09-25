<?php

use App\Http\Controllers\AuthController;

Route::post("login", [AuthController::class, "login"]);

use App\Http\Controllers\AdminController;

Route::middleware('auth:api')->group(function () {
    // Role management routes (requires 'manage-roles' permission)
    Route::middleware(['check_permission:manage-roles'])->group(function () {
        Route::post('roles', [AdminController::class, 'createRole']);
        Route::put('roles/{role}', [AdminController::class, 'updateRole']);
        Route::delete('roles/{role}', [AdminController::class, 'deleteRole']);
    });

    // Permission management routes (requires 'manage-permissions' permission)
    Route::middleware(['check_permission:manage-permissions'])->group(function () {
        Route::post('permissions', [AdminController::class, 'createPermission']);
        Route::post('roles/assign-permission', [AdminController::class, 'assignPermissionToRole']);
    });

    // User role assignment route (requires 'manage-users' permission)
    Route::middleware(['check_permission:manage-users'])->post('users/assign-role', [AdminController::class, 'assignRoleToUser']);
});