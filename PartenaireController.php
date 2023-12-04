<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partenaire;

class PartenaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partenaires = Partenaire::all();
        return view('Partenaire.index',[
            'partenaires' => $partenaires 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Partenaire.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $path = $request->file('imagepat')->store('imagepat', 'public');
        $partenaire = new Partenaire();
        $partenaire->nom = $request->nom;
        $partenaire->imagepat = $path;
        $partenaire->save();
        return redirect()->route('Partenaire.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $partenaire = Partenaire::find($id);
        return view('Partenaire.show',[
            'partenaire' => $partenaire
        ]);
    }

    public function fichier(string $id)
    {
        $partenaire = Partenaire::find($id);
        return view('Partenaire.fichier',[
            'partenaire' => $partenaire
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $partenaire = Partenaire::find($id);
        return view('Partenaire.edit',[
            'partenaire' => $partenaire
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $val = $request->validate([
            'nom' => 'required',
            'image' => 'required'
        ]);
        $partenaire = Partenaire::whereId($id)->update($val);
        return redirect()->route('Partenaire.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partenaire = Partenaire::find($id)->delete();
        return redirect()->route('Partenaire.index');
    }
}
