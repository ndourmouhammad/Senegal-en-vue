<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refreshToken']);
Route::get('/me', [AuthController::class, 'userConnecte']);
Route::post('/update', [AuthController::class, 'update'])->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/users', [AuthController::class, 'users']);
Route::get('/user/{id}', [AuthController::class, 'user']);
Route::delete('/user/{id}', [AuthController::class, 'destroy']);
Route::post('/change-role/{id}', [AuthController::class, 'changeRole']);
Route::post('/activate/{id}', [AuthController::class, 'activate']);
Route::post('/deactivate/{id}', [AuthController::class, 'deactivate']);

// Permission
Route::post('/permission', [PermissionController::class, 'ajouterPermission']);
Route::get('/permissions', [PermissionController::class, 'permissions']);
Route::post('/permission/{id}', [PermissionController::class, 'modifierPermission']);
Route::delete('/permission/{id}', [PermissionController::class, 'supprimerPermission']);

// Roles
Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:lister_roles');
Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:ajouter_role');
Route::post('/roles/{id}', [RoleController::class, 'update'])->middleware('permission:modifier_role');
Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->middleware('permission:supprimer_role');
Route::post('/roles/{id}/permission', [RoleController::class, 'givePermissions'])->middleware('permission:ajouter_permission');
