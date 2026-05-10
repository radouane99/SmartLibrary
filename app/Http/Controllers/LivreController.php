<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $themeSel = $request->get('themeSel', -1);
        $val = $request->get('val', '');
        $stock = $request->get('stock', 'all');

        $query = Livre::with('theme');

        if ($val != '') {
            $query->where(function($q) use ($val) {
                $q->where('titre', 'like', "%$val%")->orWhere('auteur', 'like', "%$val%");
            });
        }

        if ($themeSel != -1) {
            $query->where('theme_id', $themeSel);
        }

        if ($stock === 'available') {
            $query->where('nbExemplaire', '>', 0);
        }

        $db = $query->simplePaginate(8);
        $theme = Theme::all();

        if ($request->ajax()) {
            return view('livres._booksGrid', compact('db'));
        }

        return view('livres.index', compact('db', 'theme', 'themeSel', 'val', 'stock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Gate::authorize('create');
        $theme = Theme::all();
        return view('livres.create', ['theme' => $theme]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create');

        $request->validate([
            'titre' => 'bail|required',
            'auteur' => 'bail|required',
            'nbExemplaire' => 'bail|required',
            'theme_id' => 'bail|required',
            'couverture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $livre = new Livre();
        $livre->titre = $request->titre;
        $livre->auteur = $request->auteur;
        $livre->nbExemplaire = $request->nbExemplaire;
        $livre->theme_id = $request->theme_id;

        if ($request->hasFile('couverture')) {
            $livre->couverture = $request->file('couverture')->store('couvertures', 'public');
        }

        $livre->save();
        return to_route('livres.index')->with('status', "le Livre est Ajouté avec Succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(Livre $livre)
    {
        //
        // Gate::authorize('view');

        return view('livres.show', ['livre'=>$livre]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livre $livre)
    {
        //
        $theme = Theme::all();
        Gate::authorize('update', $livre);

        return view('livres.edit',['livre'=>$livre, 'theme'=>$theme]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livre $livre)
    {
        Gate::authorize('update', $livre);
        $request->validate([
            'titre' => 'bail|required',
            'auteur' => 'bail|required',
            'nbExemplaire' => 'bail|required',
            'theme_id' => 'bail|required',
            'couverture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        $livre->titre = $request->titre;
        $livre->auteur = $request->auteur;
        $livre->nbExemplaire = $request->nbExemplaire;
        $livre->theme_id = $request->theme_id;

        if ($request->hasFile('couverture')) {
            // Supprimer l'ancienne couverture
            if ($livre->couverture && \Storage::disk('public')->exists($livre->couverture)) {
                \Storage::disk('public')->delete($livre->couverture);
            }
            $livre->couverture = $request->file('couverture')->store('couvertures', 'public');
        }

        $livre->save();
        return to_route('livres.index')->with('status', "le Livre est Modifié avec Succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livre $livre)
    {
        //
        Gate::authorize('delete', $livre);
        $livre->delete();
        return to_route('livres.index')->with('status', "le Livre est Supprimé avec Succès");
    }
}
