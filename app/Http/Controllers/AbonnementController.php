<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Abonnement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SubscriptionResponse;
use App\Notifications\SubscriptionRequested;

class AbonnementController extends Controller
{
    // Méthode pour qu'un touriste demande un abonnement à un guide
    public function subscribeToGuide(Request $request, $guideId)
{
    $touriste = Auth::user(); // Récupère l'utilisateur connecté (touriste)
    $guide = User::findOrFail($guideId); // Trouve le guide
    
    // Vérifie si une demande existe déjà
    $existingSubscription = Abonnement::where('touriste_id', $touriste->id)
                                        ->where('guide_id', $guideId)
                                        ->first();
    if ($existingSubscription) {
        return response()->json(['message' => 'Vous avez déjà une demande en attente ou approuvée.'], 400);
    }

    // Crée la demande d'abonnement
    $subscription = Abonnement::create([
        'touriste_id' => $touriste->id,
        'guide_id' => $guideId,
        'status' => 'en cours',
    ]);

    // Envoyer une notification interne au guide
    $guide->notify(new SubscriptionRequested($touriste, $guide));

    return response()->json(['message' => 'Demande d\'abonnement envoyée.', 'subscription' => $subscription], 201);
}


public function respondToSubscription($subscriptionId, $status)
{
    $guide = Auth::user(); // Récupère l'utilisateur connecté (guide)
    $subscription = Abonnement::findOrFail($subscriptionId);

    // Vérifie si c'est bien le guide qui a reçu cette demande
    if ($subscription->guide_id != $guide->id) {
        return response()->json(['message' => 'Accès refusé.'], 403);
    }

    // Vérifie si le statut est bien accepté ou rejeté
    if (!in_array($status, ['accepte', 'rejete'])) {
        return response()->json(['message' => 'Statut invalide.'], 400);
    }

    // Met à jour le statut de la demande
    $subscription->status = $status;
    $subscription->save();

    // Envoyer une notification interne au touriste
    $touriste = User::findOrFail($subscription->touriste_id);
    $touriste->notify(new SubscriptionResponse($subscription, $status));

    return response()->json(['message' => 'Demande mise à jour.', 'subscription' => $subscription], 200);
}


// Méthode pour afficher toutes les demandes reçues par un guide
public function getReceivedSubscriptions()
{
    $guide = Auth::user(); // Guide connecté
    $subscriptions = $guide->subscriptionsAsGuide()->where('status', 'en cours')->get();

    return response()->json($subscriptions);
}

// Méthode pour afficher toutes les demandes faites par un touriste
public function getSentSubscriptions()
{
    $tourist = Auth::user(); // Touriste connecté
    $subscriptions = $tourist->subscriptionsAsTourist()->get();

    return response()->json($subscriptions);
}

// Nombre d'abonnés par guide connecte (avec le statut 'termine')
public function countSubscriptions()
{
    $guide = Auth::user();
    $count = Abonnement::where('guide_id', $guide->id)
                        ->where('status', 'accepte')
                        ->count();
    return response()->json(['count' => $count]);

}

public function getNotifications()
{
    $user = Auth::user();
    return response()->json($user->unreadNotifications);
}

public function markAsRead($notificationId)
{
    // Récupérer l'utilisateur connecté
    $user = Auth::user();
    
    // Récupérer la notification avec l'ID spécifié pour cet utilisateur
    $notification = $user->notifications()->find($notificationId);

    // Si la notification existe
    if ($notification) {
        // Marquer la notification comme lue (ceci met à jour automatiquement le champ read_at)
        $notification->markAsRead();
        
        // Retourner un message avec la date et l'heure de lecture (read_at)
        return response()->json([
            'message' => 'Notification marquée comme lue',
            'read_at' => $notification->read_at
        ]);
    }

    // Si la notification n'existe pas
    return response()->json(['message' => 'Notification non trouvée'], 404);
}




}
