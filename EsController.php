<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Es;

class EsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ess = Es::all();
        return view('Es.index',[
            'ess' => $ess
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Es.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $es = new Es();
        $es->nom_es = $request->nom_es;
        $es->save();
        return redirect()->route('Es.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $es = Es::find($id);
        return view('Es.show',[
            'es' => $es
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $es = Es::find($id);
        return view('Es.edit',[
            'es' => $es
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $val = $request->validate([
            'nom_es' => 'required'
        ]);
        $es = Es::whereId($id)->update($val);
        return redirect()->route('Es.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $es = Es::find($id)->delete();
        return redirect()->route('Es.index');
    }
}
