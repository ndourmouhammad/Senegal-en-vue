<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function permissions()
    {
        $permissions = Permission::all();
        return $this->customJsonResponse('List des permissions', $permissions);
    }


    // creer une permission dans mon api
    public function ajouterPermission(Request $request)
    {
        $permission = Permission::create(['name' => $request->name]);
        return $this->customJsonResponse('La permission a bien été crée', $permission);
    }

    // modifier une permission dans mon api
    public function modifierPermission(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->update();
        return $this->customJsonResponse('La permission a bien été modifié', $permission);
    }

    // supprimer une permission dans mon api
    public function supprimerPermission($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return $this->customJsonResponse('La permission a bien été supprimée', $permission);
    }
}
