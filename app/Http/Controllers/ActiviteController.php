<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreActiviteRequest;
use App\Http\Requests\UpdateActiviteRequest;

class ActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activites = Activite::all();
        return $this->customJsonResponse('List des activites', $activites);
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
    public function store(StoreActiviteRequest $request)
    {
        $activite = new Activite();
        $activite->fill($request->validated());

        if ($request->hasFile('contenu')) {
            $contenuPath = $request->file('contenu')->store('public/activites');
            $activite->contenu = str_replace('public/', '', $contenuPath);
        }

        $activite->save();
        return $this->customJsonResponse('Activite ajoute', $activite);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activite $activite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activite $activite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActiviteRequest $request, $id)
    {
        $region = Activite::findOrfail($id);
        $region->fill($request->validated());

        if ($request->hasFile('contenu')) {
            if ($region->contenu) {
                Storage::delete($region->contenu);
            }
            $contenuPath = $request->file('contenu')->store('public/activites');
            $region->contenu = str_replace('public/', '', $contenuPath);
        }

        $region->update();
        return $this->customJsonResponse('Activite modifié', $region);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activite $activite)
    {
        $activite = Activite::findOrfail($activite->id);
        $activite->delete();
        return $this->customJsonResponse('Activite supprimé', $activite);
    }
}
