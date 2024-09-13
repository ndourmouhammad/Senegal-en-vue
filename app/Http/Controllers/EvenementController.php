<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreEvenementRequest;
use App\Http\Requests\UpdateEvenementRequest;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evenement = Evenement::all();
        return $this->customJsonResponse("Liste des evenements", $evenement, 200);
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
    public function store(StoreEvenementRequest $request)
    {
        $evenement = new Evenement();
        $evenement->fill($request->validated());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/evenements');
            $evenement->image = str_replace('public/', '', $imagePath);
        }

        $evenement->save();
        return $this->customJsonResponse("Evenement cree avec succes", $evenement, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $evenement = Evenement::find($id);
        if (!$evenement) {
            return response()->json(['message' => 'Evenement non trouvé'], 404);
        }
        return $this->customJsonResponse("Evenement", $evenement, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evenement $evenement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvenementRequest $request, $id)
    {
        $evenement = Evenement::findOrfail($id);
        $evenement->fill($request->validated());
        if ($request->hasFile('image')) {
            if (File::exists(public_path($evenement->image))) {
                File::delete(public_path($evenement->image));
            }

            $imagePath = $request->file('image')->store('public/evenements');
            $evenement->image = str_replace('public/', '', $imagePath);
        }

        $evenement->save();
        return $this->customJsonResponse("Evenement mis à jour avec succes", $evenement, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $evenement = Evenement::findOrfail($id);
       $evenement->delete();
       return $this->customJsonResponse("Evenement supprimé avec succès", $evenement, 200);
    }
}
