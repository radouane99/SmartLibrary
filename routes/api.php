<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Livre;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

// 1. Route pour générer le Token (Login API)
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Les identifiants fournis sont incorrects.'],
        ]);
    }

    // Création d'un token simple
    $token = Str::random(60);
    $user->api_token = hash('sha256', $token);
    $user->save();

    return response()->json([
        'message' => 'Connexion réussie',
        'token' => $token,
        'user' => $user
    ]);
});

// Routes protégées par le Token
Route::middleware(\App\Http\Middleware\ApiTokenMiddleware::class)->group(function () {
    
    // Endpoint 1 : Récupérer tous les livres
    Route::get('/livres', function () {
        return response()->json(Livre::with('theme')->get());
    });

    // Endpoint 2 : Récupérer tous les thèmes
    Route::get('/themes', function () {
        return response()->json(Theme::all());
    });

    // Endpoint 3 : Récupérer les informations de l'utilisateur connecté
    Route::get('/user', function (Request $request) {
        return response()->json($request->api_user);
    });

    // Endpoint : Déconnexion (Révoquer le token)
    Route::post('/logout', function (Request $request) {
        $user = $request->api_user;
        $user->api_token = null;
        $user->save();
        return response()->json(['message' => 'Déconnexion réussie']);
    });
});
