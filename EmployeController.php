<?php

namespace App\Http\Controllers;
use App\Models\Employe;
use App\Models\Poste;
use App\Models\User;

use Illuminate\Http\Request;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes = Employe::all();
        return view('Employe.index',[
            'employes' => $employes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $postes = Poste::all();
        return view('Employe.create',[
            'postes' => $postes,
        ]);
    }

    public function admin(string $id)
    {
        $employe = Employe::find($id);
        return view('Employe.admin',[
            'employe' => $employe
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $path = $request->file('photo')->store('photo', 'public');
        $employe = new Employe();
        $employe->nom = $request->nom;
        $employe->prenom = $request->prenom;
        $employe->tel = $request->tel;
        $employe->email = $request->email;
        $employe->sexe = $request->sexe;
        $employe->id_poste = $request->id_poste;
        $employe->photo = $path;
        $employe->facebook = $request->facebook;
        $employe->linkedln = $request->linkedln;
        $employe->save();
        return redirect()->route('Employe.index');
    }

    public function admin_reverse(Request $request,string $id)
    {
        $employe = Employe::find($id);
        Employe::whereId($id)->update(['est_admin'=>0]);
        $uer = User::where('email',$employe->email)->delete();
        return redirect()->route('Employe.index');
    }

    public function admin_store(Request $request,string $id)
    {
        $employe = new User();
        $employe->name = Employe::find($id)->nom;
        $employe->email =Employe::find($id)->email;
        $employe->password = 'p@$$word37';
        if ($employe->save()) {
            Employe::whereId($id)->update(['est_admin'=>1]);
            return redirect()->route('Employe.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employe = Employe::find($id);
        return view('Employe.show',[
            'employe' => $employe
        ]);
    }

    public function fichier(string $id)
    {
        $employe = Employe::find($id);
        return view('Employe.fichier',[
            'employe' => $employe
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $postes = Poste::all();
        $employe = Employe::find($id);
        return view('Employe.edit',[
            'employe' => $employe,
            'postes' => $postes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $val = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'tel' => 'required',
            'email' => 'required',
            'sexe' => 'required',
            'id_poste' => 'required',
            'photo' => 'required',
            'facebook' => 'required',
            'linkedln' => 'required',
        ]);
        $employe = Employe::whereId($id)->update($val);
        return redirect()->route('Employe.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employe = Employe::find($id)->delete();
        return redirect()->route('Employe.index');
    }
}
