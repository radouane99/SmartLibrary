<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdherentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Gate::authorize('view');

        return view('adherents.index',['db'=>User::simplePaginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Gate::authorize('create');
        return view('adherents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codeA' => 'bail|required|unique:users,codeA',
            'name' => 'bail|required',
            'adresse' => 'bail|required',
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|min:6',
            'password_confirmation' => 'bail|required|same:password',
            'photo' => 'nullable|image|max:2048'
        ]);

        $adherent = new User();
        $adherent->codeA = $request->codeA;
        $adherent->name = $request->name;
        $adherent->adresse = $request->adresse;
        $adherent->email = $request->email;
        $adherent->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $adherent->role = 'adherent';

        if ($request->hasFile('photo')) {
            $adherent->photo = $request->file('photo')->store('photos', 'public');
        } else {
            $adherent->photo = 'photos/default.png';
        }

        $adherent->save();

        return to_route('adherents.index')->with('status', "L'adhérent a été ajouté avec succès !");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $adherent)
    {
        $adherent->load(['emprunts.livre']);
        return view('adherents.show', ['adherent'=>$adherent]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $adherent)
    {
        Gate::authorize('update', $adherent);

        return view('adherents.edit', ['adherent'=>$adherent]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $adherent)
    {
        Gate::authorize('update', $adherent);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $adherent->id,
            'adresse' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $adherent->name = $request->name;
        $adherent->email = $request->email;
        $adherent->adresse = $request->adresse;

        // ✅ GESTION PHOTO
        if ($request->hasFile('photo')) {
            $adherent->photo = $request->file('photo')->store('photos', 'public');
        }

        // ✅ GESTION PASSWORD (Seulement si rempli)
        if ($request->filled('password')) {
            $adherent->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $adherent->save();

        if (auth()->user()->role === 'admin' && auth()->id() != $adherent->id) {
            return to_route('adherents.index')->with('status', "Profil mis à jour avec succès !");
        }

        return back()->with('status', "Votre profil a été mis à jour !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $adherent)
    {
        Gate::authorize('delete', $adherent);

        $adherent->delete();
        return to_route('adherents.index')->with('status', "l'Adhérent est Supprimé avec Succès");
    }
}
