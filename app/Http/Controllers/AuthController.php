<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;

class AuthController extends Controller
{
    // Inscription d'un nouvel utilisateur
public function register(RegisterUserRequest $request)
{
    // Définir le statut en fonction du rôle
    $statut = $request->role === 'guide' ? 0 : 1; // 0 pour guide, 1 pour touriste

    // Création de l'utilisateur
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'photo_profil' => $request->file('photo_profil') ? str_replace('public/', '', $request->file('photo_profil')->store('public/photos_profil')) : null,
        'adresse' => $request->adresse,
        'telephone' => $request->telephone,
        'genre' => $request->genre,
        'date_naissance' => $request->date_naissance,
        'langues' => $request->langues,
        'numero_carte_guide' => $request->numero_carte_guide,
        'carte_guide' => $request->file('carte_guide') ? str_replace('public/', '', $request->file('carte_guide')->store('public/carte_guide')) : null,
        'note' => $request->note,
        'statut' => $statut, // Assurez-vous que le statut est défini en fonction du rôle
    ]);

    // Assigner le rôle à l'utilisateur en fonction de la valeur du champ 'role'
    if ($request->role === 'touriste') {
        $user->assignRole('touriste');
    } elseif ($request->role === 'guide') {
        $user->assignRole('guide');
    }

    return response()->json(['user' => $user], 201);
}

// Connexion d'un utilisateur

public function login(Request $request)
{
    // Validation
    $validator = validator($request->all(), [
        'email' => 'required|email|string',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(["errors" => $validator->errors()], 422);
    }

    $credentials = $request->only('email', 'password');
    $token = auth()->attempt($credentials);

    if (!$token) {
        return response()->json(["message" => "Informations incorrects"], 401);
    }

    $user = auth()->user();
    $user->load('roles'); // Load roles with the user

    return response()->json([
        "access_token" => $token,
        "token_type" => "Bearer",
        "user" => $user,
        "expires_in" => env('JWT_TTL') * 60 . " secondes"
    ]);
}

// Refresh API - POST
public function refreshToken()
{

    $token = auth()->refresh();

    return response()->json([
        "access_token" => $token,
        "token_type" => "Bearer",
        "user" => auth()->user(),
        "expires_in" => env('JWT_TTL') * 60 . " secondes"
    ]);
}

// Afficher les informations du user connecté
public function userConnecte(Request $request)
{
    $user = $request->user();
    $user->load('roles'); // Load roles with the user
    return response()->json($user);

}

// Modifier mes informations

public function update(Request $request)
{
    // Récupérer l'utilisateur authentifié
    $user = auth()->user();

    // Valider les nouvelles informations
    $validator = validator($request->all(), [
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'sometimes|string|min:8|confirmed',
        'photo_profil' => 'sometimes|mimes:jpeg,jpg,png,gif|max:4048',
        'adresse' => 'sometimes|string|max:255',
        'telephone' => 'sometimes|string|max:20|min:9|unique:users,telephone,' . $user->id,
        'genre' => 'sometimes|in:Homme,Femme',
        'date_naissance' => 'sometimes|date|date_format:Y-m-d',
        'langues' => 'nullable|string',
        'numero_carte_guide' => 'nullable',
        'carte_guide' => 'nullable|mimes:jpeg,jpg,png,gif|max:4048',
        'note' => 'nullable|integer|min:0|max:10',
    ]);
    

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Mettre à jour les informations de l'utilisateur
   
$user->update([
'name' => $request->name ?? $user->name,
'email' => $request->email ?? $user->email,
'password' => $request->password ? Hash::make($request->password) : $user->password,
'photo_profil' => $request->file('photo_profil') ? str_replace('public/', '', $request->file('photo_profil')->store('public/photos_profil')) : $user->photo_profil,
'adresse' => $request->adresse ?? $user->adresse,
'telephone' => $request->telephone ?? $user->telephone,
'genre' => $request->genre ?? $user->genre,
'date_naissance' => $request->date_naissance ?? $user->date_naissance,
'langues' => $request->langues ?? $user->langues,
'numero_carte_guide' => $request->numero_carte_guide ?? $user->numero_carte_guide,
'carte_guide' => $request->file('carte_guide') ? str_replace('public/', '', $request->file('carte_guide')->store('public/carte_guide')) : $user->carte_guide,
'note' => $request->note ?? $user->note,

]);


    return response()->json(['user' => $user], 200);
}

// Logout API - POST
public function logout()
{
    auth()->logout();
    return response()->json(["message" => "Vous avez bien été deconnecté"]);
}

// Lister les utilisateurs
 
 public function users()
 {
     // Charge les utilisateurs avec leurs rôles
     $users = User::with('roles')->get();
     
     // Retourne la réponse JSON personnalisée avec les utilisateurs et leurs rôles
     return $this->customJsonResponse('Liste des utilisateurs', $users);
 }

 // Trouver un utilisateur par son ID
public function user($id)
{
    // Trouver l'utilisateur avec ses rôles associés
    $user = User::with('roles')->find($id);
    
    // Vérifiez si l'utilisateur existe
    if (!$user) {
        return $this->customJsonResponse('Utilisateur non trouvé', null, 404);
    }
    
    // Retourner la réponse JSON avec l'utilisateur et ses rôles
    return $this->customJsonResponse('Utilisateur', $user);
}

 // Supprimer un utilisateur
 public function destroy($id)
 {
     $user = User::find($id);
     $user->delete();
     return $this->customJsonResponse('Utilisateur supprimé', $user);
 }

 // Changer le role d'un utilisateur avec assign role (coach ou entrepreneur)
 public function changeRole(Request $request, $id)
 {
     $user = User::find($id);
     $user->assignRole($request->role);
     return $this->customJsonResponse('Role mis a jour', $user);
 }

 // Activer un utilisateur (en changeant la valeur de son status à 1)
 public function activate($id)
 {
     $user = User::find($id);
     $user->statut = 1;
     $user->save();
     return $this->customJsonResponse('Utilisateur active', $user);
 }

  // Desactiver un utilisateur (en changeant la valeur de son status à 0)
  public function deactivate($id)
  {
      $user = User::find($id);
      $user->statut = 0;
      $user->save();
      return $this->customJsonResponse('Utilisateur desactive', $user);
  } 

  // Nombre de user avec le role guide
  public function countGuide()
  {
    $guides = User::whereHas('roles', function ($query) {
        $query->where('name', 'guide');
    })->count();
    return $this->customJsonResponse('Nombre de guides', $guides);
  }

  // Nombre de user avec le role touriste
  public function countTouriste()
  {
    $touristes = User::whereHas('roles', function ($query) {
        $query->where('name', 'touriste');
    })->count();
    return $this->customJsonResponse('Nombre de touristes', $touristes);
  }
}
 