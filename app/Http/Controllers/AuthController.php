<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;


class AuthController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }
    public function toLogin(Request $req)
    {
        $etatLog = $req->validate([
            'email'=>'bail|required|email',
            'password'=>'bail|required|min:3'
            
        ]);
        
        if(Auth::attempt($etatLog)){     
        session()->regenerate();
        return redirect()->intended(route('dashboard'));  

        }
        
	  return to_route('login')
		->withErrors(
		[
            "email"=>'Email ou mot de passe invalide'
        	])
		->withInput(['email','password']);
    }
    function logout() {
        Auth::logout();
        return to_route('home');
    }
    public function register()
    {
        return view('auth.register');
    }
    public function toRegister(Request $req){
        $req->validate([
            'codeA' => 'bail|required|unique:users',
            'nom'=>'bail|required',
            'adresse'=>'bail|required',
            'email'=>'bail|required|email|unique:users',
            'password'=>'bail|required|min:3',
            'password_confirmation'=>'bail|required|same:password',
            'photo' => 'nullable|image'   
        ]);
        $user = new User();
        $user->codeA = $req->codeA;
        $user->name=$req->nom;
        $user->email=$req->email;
        $user->adresse=$req->adresse;       
        $user->password=Hash::make($req->password);
        $user->role = 'adherent';
        // 📸 upload photo
        if($req->hasFile('photo')){
            $user->photo = $req->photo->store('photos', 'public');
        } else {
            $user->photo = 'photos/default.png';
        }
        $user->save();
        return to_route('mail', [$req->codeA, $req->nom, $req->adresse, $req->email]);
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

        return back()->with('status', 'Nous avons envoyé votre lien de réinitialisation de mot de passe par e-mail !');
    }

    public function showResetPassword($token, Request $request)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:3|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Ce jeton de réinitialisation de mot de passe n\'est pas valide.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé !');
    }
}
