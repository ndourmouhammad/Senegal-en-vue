<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\SiteTouristiqueController;

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
Route::get('/roles', [RoleController::class, 'roles']);
Route::post('/roles', [RoleController::class, 'ajouterRole']);
Route::post('/roles/{id}', [RoleController::class, 'modifierRole']);
Route::delete('/roles/{id}', [RoleController::class, 'supprimerRole']);
Route::post('/roles/{id}/permission', [RoleController::class, 'givePermissions']);

// Region 
Route::post('/regions/{id}', [RegionController::class, 'update']);
Route::apiResource('/regions', RegionController::class)->only(['index', 'store', 'destroy']);

// Activite
Route::post('/activites/{id}', [ActiviteController::class, 'update']);
Route::apiResource('/activites', ActiviteController::class)->only(['index', 'store', 'destroy']);

// Categorie
Route::post('/categories/{id}', [CategorieController::class, 'update']);
Route::apiResource('/categories', CategorieController::class)->only(['index', 'store', 'destroy']);

// Article
Route::post('/articles/{id}', [ArticleController::class, 'update']);
Route::apiResource('/articles', ArticleController::class)->only(['index', 'store', 'destroy']);

// Site Touristique
Route::post('/sites/{id}', [SiteTouristiqueController::class, 'update']);
Route::apiResource('/sites', SiteTouristiqueController::class)->only(['index', 'show', 'store', 'destroy']);

// Liaison entre site et activite
Route::post('/sites/{siteId}/activities/{activityId}', [SiteTouristiqueController::class, 'addActivityToSite']);
Route::delete('/sites/{siteId}/activities/{activityId}', [SiteTouristiqueController::class, 'removeActivityFromSite']);
Route::get('/sites/{siteId}/activities', [SiteTouristiqueController::class, 'getActivitiesOfSite']);

// Evenement
Route::post('/evenements/{id}', [EvenementController::class, 'update']);
Route::apiResource('/evenements', EvenementController::class)->only(['index', 'show', 'store', 'destroy']);