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
Route::post('/inscrire', [AuthController::class, 'inscrire']);
Route::post('/connecter', [AuthController::class, 'connecter']);


Route::middleware('auth')->group(function () {

    Route::post('/actualiserJeton', [AuthController::class, 'actualiserJeton']);
    Route::get('/utilisateurConnecte', [AuthController::class, 'afficherInformationsUtilisateurConnecte']);
    Route::post('/modifierInformations', [AuthController::class, 'modifierInformations']);
    Route::post('/deconnecter', [AuthController::class, 'deconnecter']);

    Route::prefix('users')->group(function () {
        Route::get('/', [AuthController::class, 'listerUtilisateurs'])->middleware('permission:lister les utilisateurs');
        Route::get('/{id}', [AuthController::class, 'afficherDetailsUtilisateur']);
        Route::delete('/{id}', [AuthController::class, 'supprimerUtilisateur'])->middleware('permission:bannir un utilisateur');
        Route::post('/change-role/{id}', [AuthController::class, 'changerRole'])->middleware('permission:modifier un role');
        Route::post('/activer/{id}', [AuthController::class, 'activer']);
        Route::post('/desactiver/{id}', [AuthController::class, 'desactiver']);
    });

    Route::get('/nombre-guide', [AuthController::class, 'nombreGuide']);
    Route::get('/nombre-touriste', [AuthController::class, 'nombreTouriste']);
    Route::post('/guides/{guide}/noter', [AuthController::class, 'noterGuide'])->middleware('permission:noter un guide');

    // permissions
    Route::prefix('permissions')->group(function () {
        Route::post('/', [PermissionController::class, 'ajouterPermission'])->middleware('permission:ajouter une permission');
        Route::get('/', [PermissionController::class, 'permissions'])->middleware('permission:lister les permissions');
        Route::post('/{id}', [PermissionController::class, 'modifierPermission'])->middleware('permission:modifier une permission');
        Route::delete('/{id}', [PermissionController::class, 'supprimerPermission'])->middleware('permission:supprimer une permission');
    });

    // roles
    Route::prefix('roles')->group(function () {
        Route::post('/', [RoleController::class, 'ajouterRole'])->middleware('permission:ajouter un role');
        Route::get('/', [RoleController::class, 'roles'])->middleware('permission:lister un role');
        Route::post('/{id}', [RoleController::class, 'modifierRole'])->middleware('permission:modifier un role');
        Route::delete('/{id}', [RoleController::class, 'supprimerRole'])->middleware('permission:supprimer un role');
        Route::post('/{id}/permission', [RoleController::class, 'donnerPermission'])->middleware('permission:donner une permission');
    });

    // Region
    Route::prefix('regions')->group(function () {
        Route::post('/{id}', [RegionController::class, 'update']);
        Route::apiResource('/', RegionController::class)->only(['store', 'destroy']);
    });

    // Activite
    Route::prefix('activites')->group(function () {
        Route::post('/{id}', [ActiviteController::class, 'update']);
        Route::apiResource('/', ActiviteController::class)->only(['store', 'destroy']);
    });

    // Categorie
    Route::prefix('categories')->group(function () {
        Route::post('/{id}', [CategorieController::class, 'update']);
        Route::apiResource('/', CategorieController::class)->only(['store', 'destroy']);
    });

    // Article
    Route::prefix('articles')->group(function () {
        Route::post('/{id}', [ArticleController::class, 'update'])->middleware('permission:modifier un article');
        Route::post('/', [ArticleController::class, 'store'])->middleware('permission:ajouter un article');
        Route::delete('/{id}', [ArticleController::class, 'destroy'])->middleware('permission:supprimer un article');
        Route::get('/{id}/reactions', [ArticleController::class, 'voirLesReactions']);
        Route::post('/{id}/react', [ArticleController::class, 'approuverOuDesapprouver']);
    });

    // Commentaire
    Route::prefix('articles/{id}')->group(function () {
    Route::prefix('commentaires')->group(function () {
        Route::post('/{commentaire}', [CommentaireController::class, 'update']);
        Route::post('/', [CommentaireController::class, 'store']);
        Route::delete('/{id}', [CommentaireController::class, 'destroy']);
    });
    });

    // Site Touristique
    Route::prefix('sites')->group(function () {
        Route::post('/{id}', [SiteTouristiqueController::class, 'update'])->middleware('permission:modifier un site touristique');
        Route::post('/', [SiteTouristiqueController::class, 'store'])->middleware('permission:ajouter un site touristique');
        Route::delete('/{id}', [SiteTouristiqueController::class, 'destroy'])->middleware('permission:supprimer un site touristique');
        Route::post('/{siteId}/activities/{activityId}', [SiteTouristiqueController::class, 'ajouterUneActiviteAUnSite']);
        Route::delete('/{siteId}/activities/{activityId}', [SiteTouristiqueController::class, ' supprimerUneActiviteDUnSite']);

        // Commande
        Route::post('/{id}/commande', [CommandeController::class, 'commander'])->middleware('permission:faire une commande');
        Route::get('mes-commandes', [CommandeController::class, 'mesCommandes']);
        Route::get('/{id}/commandes', [CommandeController::class, 'commandesSites']);
        Route::post('commandes/{id}/confirmer', [CommandeController::class, 'confirmerCommande'])->middleware('permission:accepter une commande');
        Route::post('commandes/{id}/refuser', [CommandeController::class, 'refuserCommande'])->middleware('permission:refuser une commande');
    });

    // evenement
    Route::prefix('evenements')->group(function () {
        Route::post('/{id}', [EvenementController::class, 'update'])->middleware('permission:modifier un evenement');
        Route::post('/', [EvenementController::class, 'store'])->middleware('permission:ajouter un evenement');
        Route::delete('/{id}', [EvenementController::class, 'destroy'])->middleware('permission:supprimer un evenement');
        Route::get('/nombre-evenements', [EvenementController::class, 'count']);

        // Reservation
        Route::post('/{id}/reservation', [ReservationController::class, 'reserver'])->middleware('permission:passer une reservation');
        Route::get('/mes-reservations', [ReservationController::class, 'mesReservations']);
        Route::get('/{id}/reservations', [ReservationController::class, 'reservationsEvenement']);
        Route::post('reservations/{id}/confirmer', [ReservationController::class, 'confirmerReservation'])->middleware('permission:refuser une reservation');
        Route::post('reservations/{id}/refuser', [ReservationController::class, 'refuserReservation'])->middleware('permission:refuser une reservation');
        Route::get('nombre-reservations', [ReservationController::class, 'count']);
        // Nombre de clients qui ont une reservation avec le statut termine
        Route::get('nombre-termine', [ReservationController::class, 'countTermine']);       
    });

    // Abonnement
    Route::prefix('abonnements')->group(function () {
        Route::post('/{id}', [AbonnementController::class, 'abonnerAUnGuide'])->middleware("permission:s'abonner a un guide");
        Route::post('/{subscriptionId}/respond/{status}', [AbonnementController::class, 'accepterOuRefuserUnAbonnement'])->middleware("permission:accepter un abonnement");
        Route::get('/received', [AbonnementController::class, 'abonnementsRecus']);
        Route::get('/sent', [AbonnementController::class, 'abonnementsEnvoyes']);
        Route::get('/abonnes', [AbonnementController::class, 'nombreAbonnes']);
        Route::get('/notifications', [AbonnementController::class, 'voirNotifications']);
        Route::post('/notifications/{id}/read', [AbonnementController::class, 'marquerNotificationCommeLue']);
    });
    
});

Route::get('/guides', [AuthController::class, 'listerGuides']);
Route::get('/guides/{id}', [AuthController::class, 'afficherDetailsGuide']);

Route::apiResource('/regions', RegionController::class)->only(['index','show']);

Route::apiResource('/activites', ActiviteController::class)->only(['index']);

Route::apiResource('/categories', CategorieController::class)->only(['index']);

Route::apiResource('/articles', ArticleController::class)->only(['index']);

Route::get('/articles/{id}/commentaires', [CommentaireController::class, 'index']);

Route::apiResource('/sites', SiteTouristiqueController::class)->only(['index', 'show']);
Route::get('/nombre-sites', [SiteTouristiqueController::class, 'nombreDeSites']);
Route::get('sites/{siteId}/activities', [SiteTouristiqueController::class, 'listerLesActivitesDunSite']);

Route::apiResource('/evenements', EvenementController::class)->only(['index', 'show']);

