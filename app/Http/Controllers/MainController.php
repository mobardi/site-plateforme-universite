<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Formation;
use App\Models\Cours;
use App\Models\Planning;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller {
    public function settings()
    {
        return view('settings');
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->save();

        return redirect('/')->with('success', 'Le nom et prénom ont été modifiés avec succès.');
    }

    public function updatePassword(Request $request)
    {
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|confirmed',
    ]);

    $user = auth()->user();
    $current_password = $user->mdp;
    if (Hash::check($request->current_password, $current_password)) {
        $user->update([
            'mdp' => Hash::make($request->password)
        ]);
        return redirect('/')->with('success', 'Votre mot de passe a été mis à jour avec succès');
    } else {
        return redirect()->back()->withErrors(['current_password' => 'Le mot de passe actuel ne correspond pas à celui fourni']);
    }
    }

    //--------ADMIN-------\\
    public function usersEdit(User $user)
    {
        if (auth()->user()->type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $formations = Formation::all();
        return view('admin.usersedit', ['user'=>$user, 'formations'=>$formations]);
    }
    public function usersUpdate(Request $request, User $user)
    {
    $user->nom = $request->input('nom');
    $user->prenom = $request->input('prenom');
    $user->login = $request->input('login');
    // Vérifier si le champ de mot de passe est rempli
    if ($request->filled('mdp')) {
        $user->mdp = Hash::make($request->input('mdp'));
    }
    $user->formation_id = $request->input('formation');
    $user->type = $request->input('type');
    $user->save();

    return redirect('/admin/users')->with('success', 'Utilisateur modifié avec succès');
    }

    public function usersDelete(User $user)
    {
        if (auth()->user()->type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    $user->delete();
    return redirect()->route('home')->with('success', 'Utilisateur supprimé');
    }

    public function usersCreate()
    {
    // Vérifier que l'utilisateur est un administrateur
    if (auth()->user()->type !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    // Récupérer la liste des formations
    $formations =Formation::all();

    // Afficher la vue avec le formulaire de création d'utilisateur
    return view('admin.userscreate', ['formations' => $formations]);
    }
    
    public function usersStore(Request $request)
    {
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'login' => 'required|string|max:255|unique:users',
        'mdp' => 'required|string',
        'type' => 'required|string|in:etudiant,enseignant,admin',
        'formation_id' => 'nullable|exists:formations,id',
    ]);

    // Création d'un nouvel utilisateur avec les données validées
    $user = new User;
    $user->nom = $validatedData['nom'];
    $user->prenom = $validatedData['prenom'];
    $user->login = $validatedData['login'];
    $user->mdp = Hash::make($validatedData['mdp']);
    $user->type = $validatedData['type'];
    $user->formation_id = $validatedData['formation_id'];
    $user->save();

    // Redirection vers la liste des utilisateurs avec un message de succès
    return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }
    
    // Création d'un nouveau cours
    public function coursCreate()
    {
    $enseignants = User::where('type', 'enseignant')->get();
    $formations = Formation::all();

    return view('admin.courscreate', ['formations' => $formations, 'enseignants' => $enseignants]);
    }

    public function coursStore(Request $request)
    {
    $request->validate([
        'intitule' => 'required',
        'enseignant_id' => 'required|exists:users,id,type,enseignant',
        'formation_id' => 'nullable|exists:formations,id',
    ]);

    $cours = new Cours();
    $cours->intitule = $request->input('intitule');
    $cours->user_id = $request->input('enseignant_id');
    $cours->formation_id = $request->input('formation_id');
    $cours->save();

    return redirect('/admin/cours')->with('success', 'Le cours a été créé avec succès.');
    }

    public function coursEdit(Cours $cour)
    {
        if (auth()->user()->type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    $enseignants = User::where('type', 'enseignant')->orderBy('nom')->get();
    $formations = Formation::orderBy('intitule')->get();
    
    return view('admin.coursedit', compact('cour', 'enseignants', 'formations'));
    }

    public function coursUpdate(Request $request, $id)
    {
        // Validation des données de la requête
        $validatedData = $request->validate([
            'intitule' => 'required|string|max:255',
            'enseignant_id' => 'required|exists:users,id',
            'formation_id' => 'nullable|exists:formations,id',
        ]);

        // Recherche du cours dans la base de données
        $cours = Cours::findOrFail($id);

        // Mise à jour des propriétés du cours
        $cours->intitule = $validatedData['intitule'];
        $cours->user_id = $validatedData['enseignant_id'];
        $cours->formation_id = $validatedData['formation_id'];

        // Enregistrement des modifications dans la base de données
        $cours->save();

        // Redirection vers la liste des cours avec un message de confirmation
        return redirect()->route('cours.index')->with('success', 'Le cours a été modifié avec succès.');
    }

    public function coursDelete($id)
    {
        $cours = Cours::findOrFail($id);
        $cours->delete();

        return redirect()->route('cours.index')->with('success', 'Le cours a été supprimé avec succès.');
    }

    // Gestion des formations
    public function formationsCreate()
    {
        if (auth()->user()->type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    return view('admin.formationscreate');
    }

    public function formationsStore(Request $request)
    {
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'intitule' => 'required|string|max:255',
    ]);

    // Création d'une nouvelle formation
    $formation = new Formation();
    $formation->intitule = $validatedData['intitule'];
    $formation->save();

    // Redirection vers la liste des formations avec un message de succès
    return redirect()->route('formations.index')->with('success', 'Formation ajoutée avec succès');
    }

    public function formationsEdit(Formation $formation)
    {
    return view('admin.formationsedit', ['formation' => $formation]);
    }

    public function formationsUpdate(Request $request, Formation $formation)
    {
    // Valider les données du formulaire
    $validatedData = $request->validate([
        'intitule' => 'required|max:255',
    ]);

    // Mettre à jour la formation avec les données du formulaire
    $formation->intitule = $validatedData['intitule'];
    $formation->save();

    // Rediriger vers la liste des formations avec un message de succès
    return redirect()->route('formations.index')->with('success', 'La formation a été mise à jour avec succès.');
    }

    public function formationsDelete(Formation $formation)
    {
        // Vérifier que l'utilisateur est un administrateur
        if (auth()->user()->type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Supprimer la formation
        $formation->delete();

        return redirect()->route('formations.index')->with('success', 'Formation supprimée avec succès');
    }


    //----------ETUDIANT------------\\

    public function etudiantFormation()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Vérifier que l'utilisateur est un étudiant
        if ($user->type !== 'etudiant') {
            abort(403, 'Unauthorized action.');
        }

        // Récupérer la formation de l'étudiant connecté
        $formation = $user->formation;

       // $cours = $formation->cours;
        // Récupérer les cours de la formation de l'étudiant connecté (+filtre)
        $cours = Cours::query()
            ->where('formation_id', '=', $formation->id)
            ->when(request()->query('q'), function ($query, $q) {
                return $query->where('intitule', 'like', "%$q%");
            })->get();


        // Afficher la vue avec la liste des cours de la formation de l'étudiant connecté
        return view('etudiant.maformation', ['cours'=>$cours , 'formation'=>$formation , 'user'=>$user]);
    }

    public function inscriptionCours(Cours $cours)
    {
        $user = auth()->user();
        if ($user->courss->contains($cours)) {
            return redirect()->back()->with('error', 'Vous êtes déjà inscrit à ce cours.');
        }
        $user->courss()->attach($cours);
        return redirect()->back()->with('success', 'Vous avez été inscrit au cours '.$cours->intitule.' avec succès.');
    }

    public function desinscriptionCours(Cours $cours)
    {
        $user = auth()->user();
        if (!$user->courss->contains($cours)) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas inscrit à ce cours.');
        }
        $user->courss()->detach($cours);
        return redirect()->back()->with('success', 'Vous avez été désinscrit du cours '.$cours->intitule.' avec succès.');
    }


    //------------ENSEIGNANT------------\\
        public function enseignantCours()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Vérifier que l'utilisateur est un enseignant
        if ($user->type !== 'enseignant') {
            abort(403, 'Unauthorized action.');
        }

        // Récupérer les cours de la formation de l'enseignant connecté
        $cours=$user->cours;
        // Afficher la vue avec la liste des cours de la formation de l'étudiant connecté
        return view('enseignant.mescours', ['cours'=>$cours]);
    }




    //---------------PLANNING-----------------\\
    public function enseignantPlanning()
    {
        // Récupérer les cours de l'enseignant connecté
        $cours = auth()->user()->cours;

        if (auth()->user()->type !== 'enseignant') {
            abort(403, 'Unauthorized action.');
        }

        // Récupérer les plannings des cours de l'enseignant
        $plannings = collect();

        foreach ($cours as $c) {
            $plannings = $plannings->merge($c->plannings);
        }
        $plannings=$plannings->sortBy('date_debut');

        // Afficher la vue avec les plannings
        return view('enseignant.planning', ['plannings' => $plannings]);
    }

        // méthode pour afficher le formulaire de création de séance
    public function enseignantSeanceCreate()
    {
        $cours = auth()->user()->cours; // récupère les cours de l'enseignant connecté
        return view('enseignant.seancecreate', ['cours'=>$cours]);
    }

    // méthode pour traiter la création de la séance
    public function enseignantSeanceStore(Request $request)
    {
        $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'date_debut' => 'required|date|before:date_fin',
            'date_fin' => 'required|date|after:date_debut'
        ]);

        $planning = new Planning();
        $planning->cours_id = $request->cours_id;
        $planning->date_debut = $request->date_debut;
        $planning->date_fin = $request->date_fin;
        $planning->save();

        return redirect()->route('enseignant.planning')->with('success', 'La séance a été créée avec succès.');
    }

        // Méthode pour afficher le formulaire de modification de la séance
    public function enseignantSeanceEdit(Planning $planning)
    {
        $cours=auth()->user()->cours;

        return view('enseignant.seanceedit', ['planning'=>$planning, 'cours'=>$cours]);
    }

    // Méthode pour mettre à jour la séance dans la base de données
    public function enseignantSeanceUpdate(Request $request, Planning $planning)
    {
        $request->validate([
            'cours_id' => 'required|exists:cours,id',
            'date_debut' => 'required|date|after:now',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $planning->cours_id = $request->cours_id;
        $planning->date_debut = $request->date_debut;
        $planning->date_fin = $request->date_fin;
        $planning->save();

        return redirect()->route('enseignant.planning')->with('success', 'Séance modifiée');
    }

    // Méthode pour supprimer la séance de la base de données
    public function enseignantSeanceDelete(Planning $planning)
    {
        $planning->delete();

        return redirect()->route('enseignant.planning')->with('success', 'Séance supprimée');
    }

    public function etudiantPlanning()
    {
        if (auth()->user()->type !== 'etudiant') {
            abort(403, 'Unauthorized action.');
        }
        $user=auth()->user();
        $formation = $user->formation;
        // Récupérer les cours de l'étudiant connecté
        //////$cours = Cours::query()->where('formation_id', '=', $formation->id)->get(); NON!
        // Récupérer les plannings des cours de l'étudiant
        $plannings = collect();

        // on recupere uniquement les cours auxquels l'etudiant est inscrit
        foreach ($user->courss as $c) {
            $plannings = $plannings->merge($c->plannings);
        }
        $plannings=$plannings->sortBy('date_debut');

        // Afficher la vue avec les plannings
        return view('etudiant.planning', ['plannings' => $plannings]);
    }
}