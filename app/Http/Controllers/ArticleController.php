<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return $this->customJsonResponse('List des articles', $articles);
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
    public function store(StoreArticleRequest $request)
    {
        $article = new Article();
        $article->fill($request->validated());

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/articles');
            $article->image = str_replace('public/', '', $imagePath);
        }

        $article->save();
        return $this->customJsonResponse('Article ajoute', $article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $article = Article::findOrfail($id);
        $article->fill($request->validated());

        if ($request->hasFile('contenu')) {
            if ($article->contenu) {
                Storage::delete($article->contenu);
            }
            $contenuPath = $request->file('contenu')->store('public/articles');
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
        $article = Article::findOrFail($id);
    $article->delete();
    return $this->customJsonResponse('Catégorie supprimée', $article);
    }

    public function approuverOuDesapprouver(Request $request, $articleId)
{
    $user = Auth::user();
    $isLike = $request->input('is_like'); // true pour like, false pour dislike

    // Vérifiez si l'utilisateur a déjà réagi à cet article
    $existingReaction = $user->likedArticles()->where('article_id', $articleId)->first();

    if ($existingReaction) {
        // Mettre à jour l'entrée existante dans la table pivot
        $user->likedArticles()->updateExistingPivot($articleId, ['is_like' => $isLike]);
        $currentReaction = $isLike ? 'like' : 'dislike';
    } else {
        // Créer une nouvelle entrée dans la table pivot
        $user->likedArticles()->attach($articleId, ['is_like' => $isLike]);
        $currentReaction = $isLike ? 'like' : 'dislike';
    }

    return response()->json([
        'message' => 'Action de like/dislike enregistrée avec succès.',
        'current_reaction' => $currentReaction, // Indique la réaction actuelle après l'action
    ]);
}

public function voirLesReactions($articleId)
{
    $likesCount = DB::table('article_user_like') 
        ->where('article_id', $articleId)
        ->where('is_like', true)
        ->count();

    $dislikesCount = DB::table('article_user_like') 
        ->where('article_id', $articleId)
        ->where('is_like', false)
        ->count();

    return response()->json([
        'message' => 'Réactions de l\'article récupérées avec succès.',
        'likes_count' => $likesCount,
        'dislikes_count' => $dislikesCount,
    ]);
}


}
