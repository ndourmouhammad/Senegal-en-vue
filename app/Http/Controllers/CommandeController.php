<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use App\Mail\CommandeAccepted;
use App\Mail\CommandeNotification;
use App\Mail\CommandeRefuse;
use App\Models\Commande;
use App\Models\SiteTouristique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommandeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommandeRequest $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        //
    }

    public function commander(Request $request, $site_historique_id)
{
    // Vérifier si l'utilisateur a déjà réservé pour cet événement
    $existingReservation = Commande::where('site_touristique_id', $site_historique_id)
                                       ->where('user_id', auth()->id())
                                       ->first();

    if ($existingReservation) {
        return response()->json([
            "status" => false,
            "message" => "Vous avez déjà réservé pour ce site historique.",
        ], 400);
    }

    // Récupérer le site historique pour vérifier le nombre de places disponibles
    $site = SiteTouristique::find($site_historique_id);

    if (!$site) {
        return response()->json([
            "status" => false,
            "message" => "Site historique introuvable.",
        ], 404);
    }

    // Vérifier s'il y a des places disponibles
    // if ($site->nombre_participant <= 0) {
    //     return response()->json([
    //         "status" => false,
    //         "message" => "Aucune place disponible pour cet événement.",
    //     ], 400);
    // }

    // Valider la requête
    $validatedData = Validator::make($request->all(), [
        'status' => 'nullable|in:en cours,termine,refuse',
    ]);

    if ($validatedData->fails()) {
        return response()->json([
            "status" => false,
            "message" => "Erreur de validation",
            "data" => $validatedData->errors()
        ], 400);
    }

    // Récupérer le statut validé ou définir une valeur par défaut
    $validated = $validatedData->validated();
    $validated['status'] = $validated['status'] ?? 'en cours';

    // Préparer les données pour la création
    $data = [
        'site_touristique_id' => $site_historique_id,
        'user_id' => auth::id(),
        'statut' => $validated['status'],
        'date_commande' => now(),
    ];

    // Créer la commande
    $commande = Commande::create($data);

    // Déduire le nombre de places disponibles
    // $evenement->nombre_participant -= 1;
    // $evenement->save();

    // Envoyer une notification par email à l'utilisateur
    Mail::to($commande->user->email)->send(new CommandeNotification($commande));

    return response()->json([
        "status" => true,
        "message" => "Réservation ajoutée avec succès",
        "data" => $commande
    ], 201);
}

public function mesCommandes()
{
    $commandes = Commande::with('site_touristique')
        ->where('user_id', auth()->id())
        ->get();

    return response()->json([
        'status' => true,
        'message' => "Commandes affichées avec succès",
        'data' => $commandes
    ], 200);
}

public function commandesSites($site_touristique_id)
{
    $commandes = Commande::where('site_touristique_id', $site_touristique_id)
                                ->whereIn('statut', ['termine', 'en cours']) // Filtrer par statut
                                ->with('user:id,name,email,telephone') // Inclure seulement l'id et le nom de l'utilisateur
                                ->get();

    return response()->json($commandes, 200);
}

public function confirmerCommande($commande_id)
{
    // Find the reservation by its ID
    $commande = Commande::findOrFail($commande_id);

    // Check if the commande status is 'en_attente'
    if ($commande->statut !== 'en cours') {
        return response()->json([
            "status" => false,
            "message" => "La réservation ne peut être confirmée car elle n'est pas en attente."
        ], 400);
    }

    // Update the status to 'accepte'
    $commande->statut = 'termine';
    $commande->save();

    // Notify the user
    Mail::to($commande->user->email)->send(new CommandeAccepted($commande));

    return response()->json([
        "status" => true,
        "message" => "Commande confirmée avec succès.",
        "data" => $commande
    ], 200);
}

public function refuserCommande($commande_id)
    {
        // Find the reservation by its ID
        $commande = Commande::findOrFail($commande_id);

        // Check if the commande status is 'en_attente'
        if ($commande->statut !== 'en cours') {
            return response()->json([
                "status" => false,
                "message" => "La commande ne peut être refusée car elle n'est pas en attente."
            ], 400);
        }

        // Update the status to 'refuse'
        $commande->statut = 'refuse';
        $commande->save();

        // Notify the user
        Mail::to($commande->user->email)->send(new CommandeRefuse($commande));

        return response()->json([
            "status" => true,
            "message" => "Commande refusée avec succès.",
            "data" => $commande
        ], 200);
    }

     // Nombre de reservations
     public function count()
     {
         $count = Commande::count();
         return $this->customJsonResponse('Nombre de reservations', $count);
     }

     // Nombre de clients qui ont une reservation avec le statut termine
    public function countTermine()
    {
        $count = Commande::where('statut', 'termine')
            ->distinct('user_id')  // Assure que chaque utilisateur est compté une seule fois
            ->count('user_id');    // Compte les utilisateurs uniques
        return $this->customJsonResponse('Nombre de clients qui ont une reservation avec le statut termine', $count);
    }
}
