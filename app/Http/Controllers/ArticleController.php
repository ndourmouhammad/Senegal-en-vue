<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
}
