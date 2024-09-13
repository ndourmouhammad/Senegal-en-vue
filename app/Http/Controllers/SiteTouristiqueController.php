<?php

namespace App\Http\Controllers;

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
        $site = new SiteTouristique();
        $site->fill($request->validated());

        if ($request->hasFile('contenu')) {
            $imagePath = $request->file('contenu')->store('public/sites');
            $site->contenu = str_replace('public/', '', $imagePath);
        }

        $site->save();
        return $this->customJsonResponse('Site ajoute', $site);
    }

    /**
     * Display the specified resource.
     */
    public function show(SiteTouristique $siteTouristique)
    {
        //
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

    public function addActivityToSite(Request $request, $siteId, $activityId)
    {
        $site = SiteTouristique::findOrFail($siteId);
        $site->activities()->attach($activityId);
        return response()->json(['message' => 'Activité ajoutée au site touristique avec succès.']);
    }

    public function removeActivityFromSite(Request $request, $siteId, $activityId)
    {
        $site = SiteTouristique::findOrFail($siteId);
        $site->activities()->detach($activityId);
        return response()->json(['message' => 'Activité retirée du site touristique avec succès.']);
    }

    public function getActivitiesOfSite($siteId)
    {
        $site = SiteTouristique::findOrFail($siteId);
        $activities = $site->activities;
        return response()->json($activities);
    }
}
