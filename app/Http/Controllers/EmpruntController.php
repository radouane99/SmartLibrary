<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;
use App\Mail\ReservationRefusee;
use App\Mail\RappelManuel;
use App\Mail\ConfirmationRetour;
use App\Mail\AdminNouvelleReservation;
use Barryvdh\DomPDF\Facade\Pdf;

class EmpruntController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dateEmpD = request('dateEmpD');
        $dateEmpF = request('dateEmpF');

        $query = Emprunt::with(['livre','user']);

        if(Auth::user()->role === 'adherent'){
            $query->where('user_id', Auth::id());
        }

        if($dateEmpD && $dateEmpF){
            $query->whereBetween('dateEmp', [$dateEmpD, $dateEmpF]);
        }

        $db = $query->orderBy('created_at', 'desc')->simplePaginate(10);

        return view('emprunts.index',[
            'db'=>$db,
            'dateEmpD'=>$dateEmpD,
            'dateEmpF'=>$dateEmpF
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livres = Livre::all();
        $adherents = User::all();
        return view('emprunts.create',['livres'=>$livres, 'adherents'=>$adherents]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'livre_id' => 'bail|required',
            'adherent_id' => 'bail|required',
            'dateEmp' => 'bail|required|after:yesterday',
            'dateRetour' => 'bail|required|after:tomorrow'
        ]);

        $livre = Livre::findOrFail($request->livre_id);
        if ($livre->nbExemplaire <= 0) {
            return back()->withErrors(['livre_id' => 'Ce livre n\'a plus d\'exemplaires disponibles !'])->withInput();
        }

        // Vérifier si l'utilisateur a déjà un emprunt actif pour ce livre
        $existingEmprunt = Emprunt::where('user_id', $request->adherent_id)
            ->where('livre_id', $request->livre_id)
            ->whereIn('statut', ['en_attente', 'valide'])
            ->first();

        if ($existingEmprunt) {
            return back()->withErrors(['livre_id' => 'Vous avez déjà un emprunt en cours pour ce livre !'])->withInput();
        }

        try {
            $emprunt = new Emprunt();
            $emprunt->livre_id = $request->livre_id;
            $emprunt->user_id = $request->adherent_id;
            $emprunt->dateEmp = $request->dateEmp;
            $emprunt->dateRetour = $request->dateRetour;
            $emprunt->statut = (Auth::user()->role === 'adherent') ? 'en_attente' : 'valide';
            $emprunt->save();

            $livre->nbExemplaire -= 1;
            $livre->save();

            if (Auth::user()->role === 'adherent') {
                // Tenter d'envoyer email à l'admin (sans bloquer si échec)
                try {
                    $admin = \App\Models\User::where('role', 'admin')->first();
                    if ($admin && $admin->email) {
                        Mail::to($admin->email)->send(new AdminNouvelleReservation($emprunt));
                    }
                } catch (\Exception $e) {
                    \Log::warning('Email admin non envoyé : ' . $e->getMessage());
                }

                return to_route('dashboard')->with('reservation_success', [
                    'livre' => $livre->titre,
                    'auteur' => $livre->auteur,
                    'date_retour' => $emprunt->dateRetour,
                ]);
            }

            $user = User::find($request->adherent_id);
            Notification::create([
                'user_id' => $user->id,
                'message' => "Votre emprunt du livre '{$livre->titre}' a été validé.",
                'type' => 'success'
            ]);

            try {
                if ($user && $user->email) {
                    Mail::to($user->email)->send(new ReservationConfirmation($emprunt));
                }
            } catch (\Exception $e) {
                \Log::warning('Email confirmation non envoyé : ' . $e->getMessage());
            }

            return to_route('emprunts.index')->with('status', "L'emprunt a été validé avec succès.");

        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()->withErrors(['livre_id' => 'Vous avez déjà réservé ce livre pour cette date. Choisissez une autre date ou un autre livre.'])->withInput();
        }
    }

    /**
     * Valider une demande d'emprunt (Admin uniquement)
     */
    public function valider(Emprunt $emprunt)
    {
        Gate::authorize('update', $emprunt);
        
        $emprunt->statut = 'valide';
        $emprunt->save();

        Notification::create([
            'user_id' => $emprunt->user_id,
            'message' => "Demande validée ! Vous pouvez récupérer le livre '{$emprunt->livre->titre}'.",
            'type' => 'success'
        ]);

        try {
            if ($emprunt->user && $emprunt->user->email) {
                Mail::to($emprunt->user->email)->send(new \App\Mail\ReservationConfirmation($emprunt));
            }
        } catch (\Exception $e) {
            \Log::error('ERREUR EMAIL VALIDATION : ' . $e->getMessage());
        }

        return back()->with('status', "L'emprunt a été validé ! Un email a été envoyé.");
    }

    /**
     * Refuser une demande de réservation (Admin uniquement)
     */
    public function refuser(Emprunt $emprunt)
    {
        Gate::authorize('update', $emprunt);

        $emprunt->statut = 'refuse';
        $emprunt->save();

        // Remettre le stock
        $livre = $emprunt->livre;
        if ($livre) {
            $livre->nbExemplaire += 1;
            $livre->save();
        }

        // Notification à l'adhérent
        Notification::create([
            'user_id' => $emprunt->user_id,
            'message' => "Votre demande pour '{$emprunt->livre->titre}' a été refusée.",
            'type' => 'danger'
        ]);

        try {
            if ($emprunt->user && $emprunt->user->email) {
                Mail::to($emprunt->user->email)->send(new \App\Mail\ReservationRefusee($emprunt));
            }
        } catch (\Exception $e) {
            \Log::error('ERREUR EMAIL REFUS : ' . $e->getMessage());
        }

        return back()->with('status', '❌ La demande a été refusée et le stock restauré.');
    }

    /**
     * Marquer un livre comme retourné (Admin uniquement)
     */
    public function retourner(Emprunt $emprunt)
    {
        Gate::authorize('update', $emprunt);

        $emprunt->statut = 'rendu';
        $emprunt->dateRetourEffective = now()->toDateString();
        $emprunt->save();

        // Remettre le stock
        $livre = $emprunt->livre;
        if ($livre) {
            $livre->nbExemplaire += 1;
            $livre->save();
        }

        // Notification à l'adhérent (Dashboard)
        Notification::create([
            'user_id' => $emprunt->user_id,
            'message' => "Merci ! Le retour de '{$emprunt->livre->titre}' a été enregistré.",
            'type' => 'success'
        ]);

        // Envoi de l'email de confirmation
        try {
            if ($emprunt->user && $emprunt->user->email) {
                Mail::to($emprunt->user->email)->send(new \App\Mail\ConfirmationRetour($emprunt));
            }
        } catch (\Exception $e) {
            \Log::error('ERREUR EMAIL RETOUR : ' . $e->getMessage());
        }

        return back()->with('status', '✅ Le livre a été marqué comme retourné et l\'adhérent a été notifié par email.');
    }

    public function rappeler(Emprunt $emprunt)
    {
        Gate::authorize('update', $emprunt);

        if (!$emprunt->user || !$emprunt->user->email) {
            return back()->withErrors(['error' => 'Cet adhérent n\'a pas d\'adresse email renseignée.']);
        }

        try {
            Mail::to($emprunt->user->email)->send(new \App\Mail\RappelManuel($emprunt));
            
            // Notification système pour l'adhérent
            Notification::create([
                'user_id' => $emprunt->user_id,
                'message' => "Rappel : L'administration demande le retour de '{$emprunt->livre->titre}'.",
                'type' => 'info'
            ]);

            return back()->with('status', '🔔 Rappel envoyé avec succès à ' . $emprunt->user->name);
        } catch (\Exception $e) {
            \Log::error('ERREUR RAPPEL MANUEL : ' . $e->getMessage());
            return back()->withErrors(['error' => 'Impossible d\'envoyer l\'email : ' . $e->getMessage()]);
        }
    }

    /**
     * Générer le reçu PDF
     */
    public function generatePDF(Emprunt $emprunt)
    {
        // Sécurité : Seul l'admin ou le propriétaire peut voir le PDF
        if (Auth::user()->role !== 'admin' && Auth::id() !== $emprunt->user_id) {
            abort(403);
        }

        $pdf = Pdf::loadView('emprunts.recu_pdf', compact('emprunt'));
        return $pdf->download('recu-emprunt-'.$emprunt->id.'.pdf');
    }

    public function show(Emprunt $emprunt)
    {
        return view('emprunts.show', ['emprunt'=>$emprunt]);
    }

    public function edit(Emprunt $emprunt)
    {
        $livres = Livre::all();
        $adherents = User::all();
        Gate::authorize('update', $emprunt);
        return view('emprunts.edit', ['emprunt'=>$emprunt, 'livres'=>$livres, 'adherents'=>$adherents]);
    }

    public function update(Request $request, Emprunt $emprunt)
    {
        if ($request->has('note')) {
            $request->validate(['note' => 'required|integer|min:1|max:5', 'commentaire' => 'nullable|string|max:500']);
            $emprunt->note = $request->note;
            $emprunt->commentaire = $request->commentaire;
            $emprunt->save();
            return back()->with('status', "Merci pour votre avis !");
        }

        Gate::authorize('update', $emprunt);
        $request->validate([
            'livre_id' => 'bail|required',
            'adherent_id' => 'bail|required',
            'dateEmp' => 'bail|required|after:yesterday',
            'dateRetour' => 'bail|required|after:tomorrow'
        ]);
        
        $emprunt->livre_id = $request->livre_id;
        $emprunt->user_id = $request->adherent_id;
        $emprunt->dateEmp = $request->dateEmp;
        $emprunt->dateRetour = $request->dateRetour;
        $emprunt->save();

        return to_route('emprunts.index')->with('status', "L'emprunt a été modifié.");
    }

    public function destroy(Emprunt $emprunt)
    {
        Gate::authorize('delete', $emprunt);
        $livre = Livre::find($emprunt->livre_id);
        if ($livre) { $livre->nbExemplaire += 1; $livre->save(); }
        $emprunt->delete();
        return to_route('emprunts.index')->with('status', "L'emprunt est terminé.");
    }

    /**
     * Export CSV des emprunts (Admin)
     */
    public function exportCSV()
    {
        $emprunts = Emprunt::with(['livre', 'user'])->orderBy('created_at', 'desc')->get();

        $filename = 'emprunts_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($emprunts) {
            $file = fopen('php://output', 'w');
            // BOM pour Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['ID', 'Livre', 'Auteur', 'Adhérent', 'Email', 'Date Emprunt', 'Date Retour Prévue', 'Retour Effectif', 'Statut'], ';');

            foreach ($emprunts as $emp) {
                fputcsv($file, [
                    $emp->id,
                    $emp->livre->titre ?? 'N/A',
                    $emp->livre->auteur ?? 'N/A',
                    $emp->user->name ?? 'N/A',
                    $emp->user->email ?? 'N/A',
                    $emp->dateEmp,
                    $emp->dateRetour,
                    $emp->dateRetourEffective ?? '—',
                    $emp->statut,
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Rapport mensuel PDF (Admin)
     */
    public function rapportMensuelPDF()
    {
        $mois = request('mois', now()->month);
        $annee = request('annee', now()->year);

        $emprunts = Emprunt::with(['livre', 'user'])
            ->whereMonth('dateEmp', $mois)
            ->whereYear('dateEmp', $annee)
            ->get();

        $stats = [
            'total' => $emprunts->count(),
            'valides' => $emprunts->where('statut', 'valide')->count(),
            'en_attente' => $emprunts->where('statut', 'en_attente')->count(),
            'rendus' => $emprunts->where('statut', 'rendu')->count(),
            'retards' => Emprunt::where('statut', 'valide')
                ->where('dateRetour', '<', now()->toDateString())
                ->whereMonth('dateEmp', $mois)
                ->whereYear('dateEmp', $annee)
                ->count(),
        ];

        $moisNom = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                     'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'][$mois];

        $pdf = Pdf::loadView('emprunts.rapport_mensuel', compact('emprunts', 'stats', 'moisNom', 'annee'));
        return $pdf->download("rapport-{$moisNom}-{$annee}.pdf");
    }

    /**
     * Liste des retards (Admin)
     */
    public function retards()
    {
        $retards = Emprunt::with(['livre', 'user'])
            ->where('statut', 'valide')
            ->where('dateRetour', '<', now()->toDateString())
            ->orderBy('dateRetour', 'asc')
            ->get();

        return view('emprunts.retards', compact('retards'));
    }
}
