<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ── STATISTIQUES GLOBALES ──
        $totalLivres     = Livre::count();
        $totalThemes     = Theme::count();
        $totalAdherents  = User::where('role', 'adherent')->count();
        $totalEmprunts   = Emprunt::count();

        // ── EMPRUNTS EN COURS (pas encore retournés = dateRetour >= aujourd'hui) ──
        $empruntsEnCours = Emprunt::where('dateRetour', '>=', now()->toDateString())->count();

        // ── EMPRUNTS EN RETARD (statut valide et dateRetour < aujourd'hui) ──
        $empruntsEnRetard = Emprunt::where('statut', 'valide')
            ->where('dateRetour', '<', now()->toDateString())
            ->count();

        // ── LIVRES SANS STOCK (nbExemplaire = 0) ──
        $livresIndisponibles = Livre::where('nbExemplaire', '<=', 0)->count();

        // ── TOTAL EXEMPLAIRES DANS LA BIBLIOTHÈQUE ──
        $totalExemplaires = Livre::sum('nbExemplaire');

        // ── LES 5 DERNIERS EMPRUNTS ──
        $derniersEmprunts = Emprunt::with(['livre', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ── TOP 5 LIVRES LES PLUS EMPRUNTÉS ──
        $topLivres = Livre::withCount('emprunts')
            ->orderByDesc('emprunts_count')
            ->take(5)
            ->get();

        // ── EMPRUNTS PAR THÈME (pour graphique Chart.js) ──
        $chartData = DB::table('themes')
            ->leftJoin('livres', 'themes.id', '=', 'livres.theme_id')
            ->leftJoin('emprunts', 'livres.id', '=', 'emprunts.livre_id')
            ->select('themes.intitule as theme', DB::raw('count(emprunts.id) as count'))
            ->groupBy('themes.id', 'themes.intitule')
            ->get();

        // ── NOTIFICATIONS RÉCENTES ──
        $recentNotifications = $user->notifications()->latest()->take(5)->get();
        $unreadCount = $user->notifications()->where('is_read', false)->count();

        // ── DONNÉES SPÉCIFIQUES ADHÉRENT ──
        $mesEmprunts       = null;
        $mesEmpruntsRetard = 0;
        $totalMesLivresLus = 0;
        $suggestions = collect();

        if ($user->role === 'adherent') {
            $mesEmprunts = Emprunt::with('livre')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $mesEmpruntsRetard = Emprunt::where('user_id', $user->id)
                ->where('dateRetour', '<', now()->toDateString())
                ->count();

            $totalMesLivresLus = Emprunt::where('user_id', $user->id)->count();

            // 🤖 ALGORITHME D'IA : RECOMMANDATION PAR THÈME
            // On récupère les IDs des thèmes les plus consultés par cet utilisateur
            $themesFavoris = Emprunt::where('user_id', $user->id)
                ->join('livres', 'emprunts.livre_id', '=', 'livres.id')
                ->select('livres.theme_id', DB::raw('count(*) as total'))
                ->groupBy('livres.theme_id')
                ->orderByDesc('total')
                ->pluck('theme_id');

            // On suggère des livres de ces thèmes qu'il n'a pas encore lu
            $livresDejaLus = Emprunt::where('user_id', $user->id)->pluck('livre_id');

            if($themesFavoris->isNotEmpty()){
                $suggestions = Livre::whereIn('theme_id', $themesFavoris)
                    ->whereNotIn('id', $livresDejaLus)
                    ->where('nbExemplaire', '>', 0)
                    ->orderByRaw('RAND()') // Un peu d'aléatoire pour la découverte
                    ->take(4)
                    ->get();
            }
            
            // Si pas assez de suggestions, on complète avec les mieux notés
            if($suggestions->count() < 4) {
                $complement = Livre::whereNotIn('id', $livresDejaLus)
                    ->where('nbExemplaire', '>', 0)
                    ->orderBy('created_at', 'desc')
                    ->take(4 - $suggestions->count())
                    ->get();
                $suggestions = $suggestions->concat($complement);
            }
        }

        return view('dashboard', compact(
            'user',
            'totalLivres',
            'totalThemes',
            'totalAdherents',
            'totalEmprunts',
            'empruntsEnCours',
            'empruntsEnRetard',
            'livresIndisponibles',
            'totalExemplaires',
            'derniersEmprunts',
            'topLivres',
            'chartData',
            'mesEmprunts',
            'mesEmpruntsRetard',
            'totalMesLivresLus',
            'suggestions',
            'recentNotifications',
            'unreadCount'
        ));
    }
}
