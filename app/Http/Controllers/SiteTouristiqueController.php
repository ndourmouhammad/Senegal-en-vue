<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activite;
use Illuminate\Http\Request;
use App\Models\SiteTouristique;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSiteTouristiqueRequest;
use App\Http\Requests\UpdateSiteTouristiqueRequest;

class SiteTouristiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = SiteTouristique::all();
        return $this->customJsonResponse('Liste des sites', $sites);
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
    public function store(StoreSiteTouristiqueRequest $request)
{
    // Création d'une nouvelle instance de SiteTouristique
    $site = new SiteTouristique();
    
    // Remplir le site avec les données validées du formulaire
    $site->fill($request->validated());

    // Vérifier si un fichier 'contenu' a été téléchargé et l'enregistrer
    if ($request->hasFile('contenu')) {
        $imagePath = $request->file('contenu')->store('public/sites');
        $site->contenu = str_replace('public/', '', $imagePath); // Supprimer 'public/' du chemin
    }

    // Assigner l'ID de l'utilisateur connecté au site touristique
    $site->user_id = auth()->id(); // Récupérer l'ID de l'utilisateur connecté

    // Enregistrer le site dans la base de données
    $site->save();

    // Retourner une réponse JSON personnalisée
    return $this->customJsonResponse('Site ajouté', $site);
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $site = SiteTouristique::findOrfail($id);
        if (!$site) {
            return response()->json(['message' => 'Site non trouvé'], 404);
        }   
        return $this->customJsonResponse('Site', $site);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteTouristique $siteTouristique)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteTouristiqueRequest $request, $id)
    {
        $site = SiteTouristique::findOrfail($id);
        $site->fill($request->validated());

        if ($request->hasFile('contenu')) {
            if ($site->contenu) {
                Storage::delete($site->contenu);
            }
            $imagePath = $request->file('contenu')->store('public/sites');
            $site->contenu = str_replace('public/', '', $imagePath);
        }

        $site->update();
        return $this->customJsonResponse('Site modifie', $site);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $site = SiteTouristique::findOrfail($id);
        $site->delete();
        return $this->customJsonResponse('Site supprime', $site);
    }

    public function ajouterUneActiviteAUnSite(Request $request, $siteId, $activityId)
    {
        $site = SiteTouristique::findOrFail($siteId);
        $site->activities()->attach($activityId);
        return response()->json(['message' => 'Activité ajoutée au site touristique avec succès.']);
    }

    public function supprimerUneActiviteDUnSite(Request $request, $siteId, $activityId)
    {
        $site = SiteTouristique::findOrFail($siteId);
        $site->activities()->detach($activityId);
        return response()->json(['message' => 'Activité retirée du site touristique avec succès.']);
    }

    public function listerLesActivitesDunSite($siteId)
    {
        $site = SiteTouristique::findOrFail($siteId);
        $activities = $site->activities;
        return response()->json($activities);
    }

    // Nombre de site touristiques
    public function nombreDeSites()
    {
        $count = SiteTouristique::count();
        return $this->customJsonResponse('Nombre de sites', $count);
    }

    // Lister les sites liees a un guide (User avec le role guide)
    public function listerLesSitesDuGuide($guideId)
    {
       // Chercher l'utilisateur par ID
    $guide = User::findOrFail($guideId);

    // Vérifier si l'utilisateur a bien le rôle de "guide"
    if (!$guide->hasRole('guide')) {
        return response()->json(['message' => 'Cet utilisateur n\'a pas le rôle de guide.'], 403);
    }

    // Récupérer les sites associés à ce guide
    $sites = $guide->sites;
        return response()->json($sites);
    }
   
}
