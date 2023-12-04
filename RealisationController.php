<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Realisation;
use App\Models\Service;
use App\Models\Option;
use App\Models\Partenaire;

class RealisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $realisations = Realisation::all();
        return view('Realisation.index',[
            'realisations' => $realisations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        $options = Option::all();
        return view('Realisation.create',[
            'services' => $services,
            'options' => $options
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $realisation = new Realisation();
        $path1 = $request->file('pathp1')->store('pathp1', 'public');
        if ($realisation->pathp2) {
            $path2 = '...';
          }
          else {
           
           $path2 = $request->file('pathp2')->store('pathp2', 'public');
          }
          if ($realisation->pathp3) {
            $path3 = '...';
          }
          else {
            $path3 = $request->file('pathp3')->store('pathp3', 'public');
            
          }
        
        $realisation->nom_realisation = $request->nom_realisation;
        $realisation->url = $request->url;
        $realisation->client = $request->client;
        $realisation->description = $request->description;
        $realisation->id_service = $request->id_service;
        $realisation->id_option = $request->id_option;
        $realisation->pathp1 = $path1;
        $realisation->pathp2 = $path2;
        $realisation->pathp3 = $path3;
        // dd($realisation);
        $realisation->save();
        return redirect()->route('Realisation.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $realisation = Realisation::find($id);
        return view('Realisation.show',[
            'realisation' => $realisation,
        ]);
    }

    public function fichier(string $id)
    {
        $realisation = Realisation::find($id);
        return view('Realisation.fichier',[
            'realisation' => $realisation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $services = Service::all();
        $options = Option::all();
        $realisation = Realisation::find($id);
        return view('Realisation.edit',[
            'realisation' => $realisation,
            'services' => $services,
            'options' => $options
        ]);
    }

    public function detail(string $id)
    {
        $partenaires = Partenaire::all();
        $c = Partenaire::count();
        $services = Service::all();
        $options = Option::all();
        $realisation = Realisation::find($id);
        return view('Realisation.detail',[
            'realisation' => $realisation,
            'services' => $services,
            'options' => $options,
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
            'nom_realisation' => 'required',
            'url' => 'required',
            'client' => 'required',
            'description' => 'required',
            'id_service' => 'required',
            'id_option' => 'required',
            'pathp1' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'pathp2' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'pathp3' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        $realisation = Realisation::whereId($id)->update($val);
        return redirect()->route('Realisation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $realisation = Realisation::find($id)->delete();
        return redirect()->route('Realisation.index');
    }
}
