<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partenaire;
use App\Models\Article;
use App\Models\Service;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return view('Article.index',[
            'articles' => $articles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $path =  $request->file('article')->store('article', 'public');
        $article = new Article();
        $article->nom = $request->nom;
        $article->description = $request->description;
        $article->categorie = $request->categorie;
        $article->prix = $request->prix;
        $article->article = $path;
        $article->save();
        return redirect()->route('Article.index');
    }

    public function fichier(string $id)
    {
        $article = Article::find($id);
        return view('Article.fichier',[
            'article' => $article
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::find($id);
        return view('Article.show',[
            'article' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::find($id);
        return view('Article.edit',[
            'article' => $article
        ]);
    }

    public function detail(string $id)
    {
        $partenaires = Partenaire::all();
        $services = Service::all();
        $c = Partenaire::count();
        $article = Article::find($id);
        return view('Article.detail',[
            'article' => $article,
            'services' => $services,
            'c' => $c,
            'partenaires' => $partenaires
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $val = $request->validate([
            'nom' => 'required',
            'description' => 'required',
            'categorie' => 'required',
        ]);
        $article = Article::whereId($id)->update($val);
        return redirect()->route('Article.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id)->delete();
        return redirect()->route('Article.index');
    }
}
