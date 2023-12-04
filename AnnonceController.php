<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\Service;
use App\Models\Categorie;
use App\Models\Partenaire;


class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annonces = Annonce::all();
        return view('Annonce.index',[
            'annonces'=>$annonces
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('Annonce.create',[
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $imagepath = $request->file('image')->store('image', 'public');
        $annonce = new Annonce();
        $annonce->nom = $request->nom;
        $annonce->titre = $request->titre;
        $annonce->contenu = $request->contenu;
        $annonce->id_categorie = $request->id_categorie;
        $annonce->image = $imagepath;
        $annonce->save();
        return redirect()->route('Annonce.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $annonce = Annonce::find($id);
        return view('Annonce.show',[
            'annonce' => $annonce
        ]);
    }

    public function fichier(string $id)
    {
        $annonce = Annonce::find($id);
        return view('Annonce.fichier',[
            'annonce' => $annonce
        ]);
    }

    public function detail(string $id)
    {
        $as = Annonce::orderBy('created_at', 'desc')->limit(4)->get();
        $partenaires = Partenaire::all();
        $c = Partenaire::count();
        $categories = Categorie::all();
        $services = Service::all();
        $annonce = Annonce::find($id);
        $annonces= Annonce::all();
        return view('Annonce.detail',[
            'annonce' => $annonce,
            'services' => $services,
            'categories' => $categories,
            'annonces' => $annonces,
            'c' => $c,
            'partenaires' => $partenaires,
            'as' => $as,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Categorie::all();
        $annonce = Annonce::find($id);
        return view('Annonce.edit',[
            'annonce' => $annonce,
            'categories' => $categories
        ]);
    }

    public function categorie(string $id){
        $annonces = Annonce::all()->where(
            'id_categorie',$id
        );
        return redirect()->route('Annonce.index');
        // return view('Page.annonce',[
        //     'annonces' => $annonces
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $val = $request->validate([
            'nom' => 'required',
            'titre' => 'required',
            'contenu' => 'required',
            'id_categorie' => 'required',
            'image' => 'required',
        ]);
        $annonce = Annonce::whereId($id)->update($val);
        return redirect()->route('Annonce.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $annconce = Annonce::find($id)->delete();
        return redirect()->route('Annonce.index');
    }
}
