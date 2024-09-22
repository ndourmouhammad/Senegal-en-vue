<?php

namespace App\Http\Controllers;


use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($articleId)
    {
        $commentaires = Commentaire::with('user') // Assurez-vous que la relation est définie dans le modèle Commentaire
            ->where('article_id', $articleId)
            ->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Commentaires récupérés avec succès',
            'data' => $commentaires
        ], 200);
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
    public function store(Request $request, $articleId)
    {
        $validator=Validator::make($request->all(), [
            "contenu"=> "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }
        $commentaires=Commentaire::create([
            "article_id"=>$articleId,
            "contenu"=> $request->contenu,
            "user_id"=> Auth::id(),
            "date_publication"=> now(),
            "heure_publication"=> now(),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Commentaire ajouté avec succès',
            'data' => $commentaires
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Commentaire $commentaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $articleId, $id)
    {
        $article = Article::findOrFail($articleId);
        $commentaires=Commentaire::findOrFail($id);
        $commentaires = $article->commentaires()->findOrFail($id);

        if($commentaires->user_id != Auth::id()){
            return response()->json(["error"=>"Unauthorized"],403);
        }
        $validator=Validator::make($request->all(), [
            "contenu"=> "sometimes|string",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $commentaires->update($request->only("contenu"));
        return response()->json([
            'status' => true,
            'message' => 'Commentaire mis à jour avec succès',
            'data' => $commentaires
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($articleId,$id)
    {
        $article = Article::findOrFail($articleId);
        $commentaires=Commentaire::findOrFail($id);
        $commentaires = $article->commentaires()->findOrFail($id);
        if($commentaires->user_id != Auth::id()){
            return response()->json(["error"=> "Unauthorized"],403);
        }
       
        $commentaires->delete();
        return response()->json(['message'=>'commentaire supprimer avec succé'],200);
    }
}
