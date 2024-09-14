<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Mail\ReservationRefuse;
use App\Mail\ReservationAccepted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationNotification;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
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
    public function store(StoreReservationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    public function reserver(Request $request, $evenement_id)
    {
        // Vérifier si l'utilisateur a déjà réservé pour cet événement
        $existingReservation = Reservation::where('evenement_id', $evenement_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReservation) {
            return response()->json([
                "status" => false,
                "message" => "Vous avez déjà réservé pour cet événement.",
            ], 400);
        }

        // Récupérer l'événement pour vérifier le nombre de places disponibles
        $evenement = Evenement::find($evenement_id);

        if (!$evenement) {
            return response()->json([
                "status" => false,
                "message" => "Événement non trouvé.",
            ], 404);
        }

        // Vérifier s'il y a des places disponibles
        if ($evenement->nombre_participant <= 0) {
            return response()->json([
                "status" => false,
                "message" => "Aucune place disponible pour cet événement.",
            ], 400);
        }

        // Valider la requête
        $validatedData = Validator::make($request->all(), [
            'statut' => 'nullable|in:en cours,termine,refuse',
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
        $validated['statut'] = $validated['statut'] ?? 'en cours';

        // Préparer les données pour la création
        $data = [
            'evenement_id' => $evenement_id,
            'user_id' => auth::id(),
            'statut' => $validated['statut'],
            'date_reservation' => now(),
            'heure_reservation' => now(),
        ];

        // Créer la réservation
        $reservation = Reservation::create($data);

        // Déduire le nombre de places disponibles
        $evenement->nombre_participant -= 1;
        $evenement->save();

        // Envoyer une notification par email à l'utilisateur
        Mail::to($reservation->user->email)->send(new ReservationNotification($reservation));

        return response()->json([
            "status" => true,
            "message" => "Réservation ajoutée avec succès",
            "data" => $reservation
        ], 201);
    }

    public function mesReservations()
    {
        $reservations = Reservation::with('evenement')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'status' => true,
            'message' => "Réservations affichées avec succès",
            'data' => $reservations
        ], 200);
    }

    public function reservationsEvenement($evenement_id)
    {
        $reservations = Reservation::where('evenement_id', $evenement_id)
            ->whereIn('statut', ['termine', 'en cours']) // Filtrer par statut
            ->with('user:id,name,email,telephone') // Inclure seulement l'id et le nom de l'utilisateur
            ->get();

        return response()->json($reservations, 200);
    }

    public function confirmerReservation($reservation_id)
    {
        // Find the reservation by its ID
        $reservation = Reservation::findOrFail($reservation_id);

        // Check if the reservation status is 'en_attente'
        if ($reservation->statut !== 'en cours') {
            return response()->json([
                "status" => false,
                "message" => "La réservation ne peut être confirmée car elle n'est pas en attente."
            ], 400);
        }

        // Update the status to 'accepte'
        $reservation->statut = 'termine';
        $reservation->save();

        // Notify the user
        Mail::to($reservation->user->email)->send(new ReservationAccepted($reservation));

        return response()->json([
            "status" => true,
            "message" => "Réservation confirmée avec succès.",
            "data" => $reservation
        ], 200);
    }

    public function refuserReservation($reservation_id)
    {
        // Find the reservation by its ID
        $reservation = Reservation::findOrFail($reservation_id);

        // Check if the reservation status is 'en_attente'
        if ($reservation->statut !== 'en cours') {
            return response()->json([
                "status" => false,
                "message" => "La réservation ne peut être refusée car elle n'est pas en attente."
            ], 400);
        }

        // Update the status to 'refuse'
        $reservation->statut = 'refuse';
        $reservation->save();

        // Notify the user
        Mail::to($reservation->user->email)->send(new ReservationRefuse($reservation));

        return response()->json([
            "status" => true,
            "message" => "Réservation refusée avec succès.",
            "data" => $reservation
        ], 200);
    }

    // Nombre de reservations
    public function count()
    {
        $count = Reservation::count();
        return $this->customJsonResponse('Nombre de reservations', $count);
    }

    // Nombre de clients qui ont une reservation avec le statut termine
    public function countTermine()
    {
        $count = Reservation::where('statut', 'termine')
            ->distinct('user_id')  // Assure que chaque utilisateur est compté une seule fois
            ->count('user_id');    // Compte les utilisateurs uniques
        return $this->customJsonResponse('Nombre de clients qui ont une reservation avec le statut termine', $count);
    }
}
