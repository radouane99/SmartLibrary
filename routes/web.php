<?php

use App\Http\Controllers\AdherentController;
use App\Http\Controllers\AdherentLivreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BibliothequeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\ThemeController;
use App\Http\Middleware\ConnexionMiddleware;
use App\Http\Middleware\EmpruntMiddleware;
use App\Mail\AlertMail;
use App\Models\Emprunt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    $totalLivres = \App\Models\Livre::count();
    $totalAdherents = \App\Models\User::where('role', 'adherent')->count();
    $totalThemes = \App\Models\Theme::count();
    $totalEmprunts = \App\Models\Emprunt::count();
    $livresPopulaires = \App\Models\Livre::withCount('emprunts')
        ->with('theme')
        ->orderByDesc('emprunts_count')
        ->where('nbExemplaire', '>', 0)
        ->take(6)
        ->get();
    $themes = \App\Models\Theme::withCount('livres')->get();
    return view('acceuil', compact('totalLivres', 'totalAdherents', 'totalThemes', 'totalEmprunts', 'livresPopulaires', 'themes'));
})->name('home');



Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('livres', LivreController::class)->except(['index', 'show']);
    Route::resource('themes', ThemeController::class)->except(['index', 'show']);
    Route::resource('adherents', AdherentController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('emprunts', EmpruntController::class)->only(['edit', 'update', 'destroy']);
    Route::get('/admin/export-emprunts', [EmpruntController::class, 'exportCSV'])->name('emprunts.export');
    Route::get('/admin/rapport-mensuel', [EmpruntController::class, 'rapportMensuelPDF'])->name('admin.rapport');
    Route::get('/admin/retards', [EmpruntController::class, 'retards'])->name('admin.retards');
});

// Catalogue public (pas besoin de login)
Route::resource('livres', LivreController::class)->only(['index', 'show']);
Route::resource('themes', ThemeController::class)->only(['index', 'show']);

Route::middleware(['auth'])->group(function () {
    Route::get('/adherents/{adherent}/edit', [AdherentController::class, 'edit'])->name('adherents.edit');
    Route::put('/adherents/{adherent}', [AdherentController::class, 'update'])->name('adherents.update');
    Route::get('/adherents/{adherent}', [AdherentController::class, 'show'])->name('adherents.show');
    Route::resource('emprunts', EmpruntController::class)->only(['index', 'show', 'create', 'store']);
});

Route::get('/mail/{codeA}/{name}/{adresse}/{email}', function ($codeA,$name,$adresse,$email) {
    
    Mail::to($email)->send(new AlertMail(['codeA'=>$codeA, 'name'=>$name, 'adresse'=>$adresse,'email'=>$email]));
    return view('auth.login');

    // return view('emprunts.index',['msg'=>"Les emails de l'Alert ont été Envoyé", 'db'=>Emprunt::all()]);
})->name('mail');


Route::get('login',[AuthController::class,"login"])->name("login");
Route::post('toLogin',[AuthController::class,"toLogin"])->name("toLogin");
Route::get('register',[AuthController::class,"register"])->name("register");
Route::post('toRegister',[AuthController::class,"toRegister"])->name("toRegister");
Route::delete('logout',[AuthController::class,"logout"])->name("logout");

// Password Reset Routes
Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'updatePassword'])->name('password.update');

Route::post('/emprunts/{emprunt}/valider', [EmpruntController::class, 'valider'])->name('emprunts.valider')->middleware('auth');
Route::post('/emprunts/{emprunt}/refuser', [EmpruntController::class, 'refuser'])->name('emprunts.refuser')->middleware(['auth', 'admin']);
Route::post('/emprunts/{emprunt}/retourner', [EmpruntController::class, 'retourner'])->name('emprunts.retourner')->middleware(['auth', 'admin']);
Route::post('/emprunts/{emprunt}/rappeler', [EmpruntController::class, 'rappeler'])->name('emprunts.rappeler')->middleware(['auth', 'admin']);
Route::get('/emprunts/{emprunt}/pdf', [EmpruntController::class, 'generatePDF'])->name('emprunts.pdf')->middleware('auth');
