<?php

namespace App\Http\Controllers;

use FFI;
use App\Models\Region;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::all();
        return $this->customJsonResponse('List des regions', $regions);
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
    public function store(StoreRegionRequest $request)
    {
        $region = new Region();
        $region->fill($request->validated());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/photos_regions');
            $region->image = str_replace('public/', '', $imagePath);
        }

        $region->save();
        return $this->customJsonResponse('Region ajoute', $region);
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegionRequest $request, $id)
    {
        $region = Region::findOrfail($id);
        $region->fill($request->validated());
        
        // supprimer avant d'enregistrer une nouvelle image
        if ($request->hasFile('image')) {
            if(File::exists(public_path($region->image))){
                File::delete(public_path($region->image));
            }

            $imagePath = $request->file('image')->store('public/photos_regions');
            $region->image = str_replace('public/', '', $imagePath);
        }


        $region->update();
        return $this->customJsonResponse('Region modifié', $region);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        $region = Region::findOrfail($region->id);
        $region->delete();
        return $this->customJsonResponse('Region supprimé', $region);
    }
}
