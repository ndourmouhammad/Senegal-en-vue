<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Models\Categorie;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::all();
        return $this->customJsonResponse('List des categories', $categories);
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
    public function store(StoreCategorieRequest $request)
    {
        $categorie = new Categorie();
        $categorie->fill($request->validated());
        $categorie->save();
        return $this->customJsonResponse('Categorie ajoute', $categorie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieRequest $request, $id)
    {
        $categorie = Categorie::findOrfail($id);
        $categorie->fill($request->validated());
        $categorie->save();
        return $this->customJsonResponse('Categorie modifié', $categorie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $categorie = Categorie::findOrFail($id);
    $categorie->delete();
    return $this->customJsonResponse('Catégorie supprimée', $categorie);
}


}
