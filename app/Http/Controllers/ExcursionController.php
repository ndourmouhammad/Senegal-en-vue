<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Excursion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreExcursionRequest;
use App\Http\Requests\UpdateExcursionRequest;

class ExcursionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $excursions = Excursion::all();
        return $this->customJsonResponse('Liste des excursions', $excursions);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExcursionRequest $request)
    {
        $excursion = new Excursion();
        $excursion->fill($request->validated());
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/excursions');
            $excursion->image = str_replace('public/', '', $imagePath);
        }
        if ($request->hasFile('contenu')) {
            $contenuPath = $request->file('contenu')->store('public/excursions');
            $excursion->contenu = str_replace('public/', '', $contenuPath);
        }
        $excursion->user_id = auth()->id();
        $excursion->save();
        return $this->customJsonResponse('Excursion ajoute', $excursion);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $excursion = Excursion::findOrfail($id);
        if (!$excursion) {
            return response()->json(['message' => 'Excursion nonTrouve'], 404);
        }
        return $this->customJsonResponse('Excursion', $excursion);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExcursionRequest $request, $id)
    {
        $excursion = Excursion::findOrfail($id);
        $excursion->fill($request->validated());
        if ($request->hasFile('image')) {
            if ($excursion->image) {
                Storage::delete($excursion->image);
            }
            $imagePath = $request->file('image')->store('public/excursions');
            $excursion->image = str_replace('public/', '', $imagePath);
        }
        if ($request->hasFile('contenu')) {
            if ($excursion->contenu) {
                Storage::delete($excursion->contenu);
            }
            $contenuPath = $request->file('contenu')->store('public/excursions');
            $excursion->contenu = str_replace('public/', '', $contenuPath);
        }
        $excursion->update();
        return $this->customJsonResponse('Excursion modifié', $excursion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $excursion = Excursion::findOrfail($id);
        $excursion->delete();
        return $this->customJsonResponse('Excursion supprimé', $excursion);
    }

    // Ajouter une activite à une excursion
    public function ajouterUneActiviteAUneExcursion(Request $request, $excursion_id, $activite_id)
    {
        $excursion = Excursion::findOrfail($excursion_id);
        $excursion->activites()->attach($activite_id);
        return $this->customJsonResponse('Activite ajoutée', $excursion);
    }

    // Supprimer une activite d'une excursion
    public function supprimerUneActiviteAUneExcursion(Request $request, $excursion_id, $activite_id)
    {
        $excursion = Excursion::findOrfail($excursion_id);
        $excursion->activites()->detach($activite_id);
        return $this->customJsonResponse('Activite supprimée', $excursion);
    }

    // Lister les activites d'une excursion
    public function listerLesActivitesDUneExcursion($excursion_id)
    {
        $excursion = Excursion::findOrfail($excursion_id);
        $activites = $excursion->activites;
        return $this->customJsonResponse('Liste des activites', $activites);
    }

    // Nombre de excursions
    public function nombreDeExcursion()
    {
        $userId = auth()->id();
        $count = Excursion::where('user_id', $userId)->count();
        return $this->customJsonResponse('Nombre de excursions', $count);
    }

    // Lister les sites liees a un guide (User avec le role guide)
    public function listerLesExcursionsDuGuide($guideId)
    {
       // Chercher l'utilisateur par ID
    $guide = User::findOrFail($guideId);

    // Vérifier si l'utilisateur a bien le rôle de "guide"
    if (!$guide->hasRole('guide')) {
        return response()->json(['message' => 'Cet utilisateur n\'a pas le rôle de guide.'], 403);
    }

    
    $excursions = $guide->excursions;
        return response()->json($excursions);
    }
    
}
