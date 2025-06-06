<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dentiste;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('pages.Login'); 
    }

    public function dentiste_connection(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'motdepasse' => 'required|string',
        ]);
    
        $dentiste = Dentiste::where('email', $request->email)->first();
    
        if ($dentiste && Hash::check($request->motdepasse, $dentiste->motdepasse)) {
            session(['dentiste_id' => $dentiste->id]);
            session(['dentiste_nom' => $dentiste->nom]);
            session(['dentiste_prenom' => $dentiste->prenom]);  
            session(['email' => $dentiste->email]);
            session(['dentiste_numero' => $dentiste->numero]);
            session(['motdepasse' => $dentiste->motdepasse]);
            session(['motdepasse' => $dentiste->motdepasse]);
            $avatar = $dentiste->avatar ? asset($dentiste->avatar) : asset('images/profiles/default-avatar.jpg');
            session(['dentiste_avatar' => $avatar]);
            // $avatar = $dentiste->avatar ? asset($dentiste->avatar) : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
            // session(['dentiste_avatar' => $avatar]);


    
            return redirect('/accueil')->with('message', 'Connexion réussie !');
        } else {
            return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])->withInput();
        }
    }
    
    public function logout()
    {
        // Effacer toutes les données de la session
        session()->flush();
    
        // Rediriger l'utilisateur vers la page de connexion ou une autre page
        return redirect('/login')->with('message', 'Déconnexion réussie !');
    }
    
    public function creation_compte()
    {
        return view('pages.creation_compte'); 
    }
}
