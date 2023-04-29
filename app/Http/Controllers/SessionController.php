<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Formation;
use App\Models\Cours;
use App\Models\Planning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller {
    
    /**
     * Création de compte
        */
    public function newUserForm() {
        $formations = Formation::all();
        if (Auth::check()) return redirect("/")->with("erreur", "Il faut être déconnecté pour pouvoir créer un nouveau compte.");

        return view("auth.register", ['formations' => $formations]);
    }
    public function newUser(Request $request) {
        $request->validate([
            "nom" => "required|string|max:40",
            "prenom" => "required|string|max:40",
            "login" => "required|string|max:30|unique:users",
            "mdp" => "required|string|confirmed",
        ]);

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->login = $request->login;
        $user->mdp = Hash::make($request->mdp);
        
        // Vérifier si l'utilisateur est un étudiant ou un enseignant/admin
        if ($request->formation_id == null) {
            // Si la formation choisie est "Aucune Formation", alors l'utilisateur est un enseignant/admin donc type=null
            $user->type = 'enseignant';
            $user->formation_id = null;
        } else {
            // Sinon, c'est un étudiant
            $user->type = null; // Par défaut, le type est null pour les étudiants en attendant que l'admin valide ou pas l'inscription
            $user->formation_id = $request->formation_id;
        }
        /** NB** :
         * la combinaison de type + formation :
         * si type = NULL et formation_id = NULL, alors c'est un admin ou enseignant (à prévoir donc 2 choix)
         * si le type=null et formation_id <> null, alors c'est un étudiant
         */
        $user->save();

        //session()->flash("etat", "Demande de création de compte envoyée avec succès.");

        return redirect("/")->with('success', 'Votre compte a été créé avec succès !');
    }

    /*
     * Formulaire de connexion
    */
    public function loginForm() {
        if (Auth::check()) return redirect("/")->with("erreur", "Il faut être déconnecté pour pouvoir se connecter à un compte.");

        return view("auth.login");
    }
    /**
     * Connexion
     */
    public function login(Request $request) {
        $request->validate([
            "login" => "required|string",
            "mdp" => "required|string"
        ]);

        $credentials = ["login" => $request->input("login"),
            "password" => $request->input("mdp")];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended("/")->with('success', 'Connecté(e)!');
        }

        return redirect()->back()->withErrors([
            "login" => "Les informations de connexion sont incorrectes."
        ]);
    }

    /**
     * Déconnexion
    */
    public function logout(Request $request) {
        if (!Auth::check()) return redirect("/")->with("erreur", "Il faut être connecté pour pouvoir se déconnecter.");;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/");
    }

}