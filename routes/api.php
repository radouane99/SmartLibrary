<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Livre;
use App\Models\Theme;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. Route pour générer un Token rapidement (Utile pour le rapport)
// URL: http://127.0.0.1:8000/api/dev-token
Route::get('/dev-token', function () {
    $user = User::first(); // Prend le premier utilisateur de la base
    if (!$user) {
        return response()->json(['error' => 'Aucun utilisateur trouvé. Lancez le seeder.'], 404);
    }
    // Supprime les anciens tokens pour éviter l'encombrement
    $user->tokens()->delete();

    return $user->createToken('dev-token')->plainTextToken;
});

// 2. Routes protégées par Sanctum
// Ces routes demandent obligatoirement un Bearer Token dans Postman
Route::middleware('auth:sanctum')->group(function () {

    // Récupérer tous les livres avec leurs thèmes
    Route::get('/livres', function () {
        return response()->json(Livre::with('theme')->get());
    });

    // Récupérer tous les thèmes
    Route::get('/themes', function () {
        return response()->json(Theme::all());
    });

    // Récupérer l'utilisateur actuellement connecté via le Token
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // Déconnexion (Supprime le token actuel)
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie, token supprimé.']);
    });
});