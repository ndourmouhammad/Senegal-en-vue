<?php

use App\Http\Controllers\AbonnementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ReservationController;
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
// Nombre de guide
Route::get('/nombre-guide', [AuthController::class, 'countGuide']);
Route::get('/nombre-touriste', [AuthController::class, 'countTouriste']);
// Noter un guide
Route::post('/guides/{guide}/rate', [AuthController::class, 'storeRating']);


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
Route::post('/articles/{articleId}/react', [ArticleController::class, 'likeOrDislike'])->middleware('auth');
Route::get('/articles/{articleId}/reactions', [ArticleController::class, 'getArticleReactions']);

// Commentaire
Route::prefix('articles/{id}')->group(function () {
    Route::get('commentaires', [CommentaireController::class, 'index']);
    Route::post('commentaires', [CommentaireController::class, 'store']);
    Route::post('commentaires/{commentaire}', [commentaireController::class, 'update']);
    Route::delete('commentaires/{commentaire}', [CommentaireController::class, 'destroy']);
});

// Site Touristique
Route::post('/sites/{id}', [SiteTouristiqueController::class, 'update']);
Route::apiResource('/sites', SiteTouristiqueController::class)->only(['index', 'show', 'store', 'destroy']);
Route::get('/nombre-sites', [SiteTouristiqueController::class, 'count']);

// Liaison entre site et activite
Route::post('/sites/{siteId}/activities/{activityId}', [SiteTouristiqueController::class, 'addActivityToSite']);
Route::delete('/sites/{siteId}/activities/{activityId}', [SiteTouristiqueController::class, 'removeActivityFromSite']);
Route::get('/sites/{siteId}/activities', [SiteTouristiqueController::class, 'getActivitiesOfSite']);

// Evenement
Route::post('/evenements/{id}', [EvenementController::class, 'update']);
Route::apiResource('/evenements', EvenementController::class)->only(['index', 'show', 'store', 'destroy']);
Route::get('/nombre-evenements', [EvenementController::class, 'count']);

// Reservation
Route::post('evenements/{id}/reservation', [ReservationController::class, 'reserver']);
Route::get('mes-reservations', [ReservationController::class, 'mesReservations']);
Route::get('evenements/{id}/reservations', [ReservationController::class, 'reservationsEvenement']);
Route::post('reservations/{id}/confirmer', [ReservationController::class, 'confirmerReservation']);
Route::post('reservations/{id}/refuser', [ReservationController::class, 'refuserReservation']);
Route::get('nombre-reservations', [ReservationController::class, 'count']);
// Nombre de clients qui ont une reservation avec le statut termine
Route::get('nombre-termine', [ReservationController::class, 'countTermine']);

// Commande
Route::post('sites/{id}/commande', [CommandeController::class, 'commander']);
Route::get('mes-commandes', [CommandeController::class, 'mesCommandes']);
Route::get('sites/{id}/commandes', [CommandeController::class, 'commandesSites']);
Route::post('commandes/{id}/confirmer', [CommandeController::class, 'confirmerCommande']);
Route::post('commandes/{id}/refuser', [CommandeController::class, 'refuserCommande']);


// Abonnement
Route::middleware('auth:api')->group(function () {
    // Route pour qu'un touriste demande un abonnement à un guide
    Route::post('subscribe/{guideId}', [AbonnementController::class, 'subscribeToGuide']);

    // Route pour qu'un guide accepte ou rejette une demande
    Route::post('subscriptions/{subscriptionId}/respond/{status}', [AbonnementController::class, 'respondToSubscription']);


    // Route pour afficher les demandes reçues par le guide
    Route::get('subscriptions/received', [AbonnementController::class, 'getReceivedSubscriptions']);

    // Route pour afficher les demandes envoyées par le touriste
    Route::get('subscriptions/sent', [AbonnementController::class, 'getSentSubscriptions']);

    // Nombre d'abonnés par guide connecte (avec le statut 'termine')
    Route::get('subscriptions/count', [AbonnementController::class, 'countSubscriptions']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/notifications', [AbonnementController::class, 'getNotifications']);
    Route::post('/notifications/{id}/read', [AbonnementController::class, 'markAsRead']);
});