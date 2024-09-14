<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Abonnement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

}
