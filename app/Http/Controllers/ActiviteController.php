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
    public function show($id)
    {
        $activite = Activite::findOrfail($id);
        if (!$activite) {
            return response()->json(['message' => 'activite non trouvé'], 404);
        }   
        return $this->customJsonResponse('activite', $activite);
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
        $article = Activite::findOrfail($id);
        $article->fill($request->validated());

        if ($request->hasFile('contenu')) {
            if ($article->contenu) {
                Storage::delete($article->contenu);
            }
            $contenuPath = $request->file('contenu')->store('public/activites');
            $article->contenu = str_replace('public/', '', $contenuPath);
        }

        $article->update();
        return $this->customJsonResponse('Activite modifié', $article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $activite = Activite::findOrfail($id);
        $activite->delete();
        return $this->customJsonResponse('Activite supprimé', $activite);
    }
}
