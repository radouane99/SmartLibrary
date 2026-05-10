<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $val = Theme::with('livres')->get();
        // dd($val);
        return view('themes.index',['db'=>Theme::simplePaginate(10)]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Gate::authorize('create');

        return view('themes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            //     'codeTh' => 'bail|required',
                'intitule' => 'bail|required',
            ]);
            // dd($request->codeTh);
            $theme = new Theme();
            // $theme->codeTh = $request->codeL;
            $theme->intitule = $request->intitule;
       
            $theme->save();
            return to_route('themes.index')->with('status', "le Thème est Ajouté avec Succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        //
        return view('themes.show',['theme'=>$theme]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme)
    {
        //
        Gate::authorize('update', $theme);

        return view('themes.edit',['theme'=>$theme]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theme $theme)
    {
        //
        Gate::authorize('update', $theme);

        $request->validate([
            // 'codeTh' => 'bail|required',
            'intitule' => 'bail|required',
        ]);
        $theme->intitule = $request->intitule;
        $theme->save();
        return to_route('themes.index')->with('status', "le Thème est Modifié avec Succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        //
        Gate::authorize('delete', $theme);

        $theme->delete();
        return to_route('themes.index')->with('status', "le Thème est Supprimé avec Succès");
    }
}
