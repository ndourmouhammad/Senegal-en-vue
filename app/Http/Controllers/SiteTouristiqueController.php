<?php

namespace App\Http\Controllers;

use App\Models\User;
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
     * Store a newly created resource in storage.
     */
    public function store(StoreSiteTouristiqueRequest $request)
    {
        
        $site = new SiteTouristique();
        $site->fill($request->validated());
        if ($request->hasFile('contenu')) {
            $imagePath = $request->file('contenu')->store('public/sites');
            $site->contenu = str_replace('public/', '', $imagePath);
        }
        $site->user_id = auth()->id();
        $site->save();
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

    // Nombre de site 
    public function nombreDeSite()
    {
        $count = SiteTouristique::count();
        return $this->customJsonResponse('Nombre de site', $count);
    }
}
